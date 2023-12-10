<link rel = "stylesheet" href="board2.css">
<?php
//절대경로로 접근, Nginx에 DB정보가 미리 준비되어 있어야함
$db_config = parse_ini_file('/config/nginx/db_config.ini');
// MySQL 데이터베이스 연결 정보
$servername = $db_config['host'];
$username   = $db_config['username'];
$password   = $db_config['password'];
$dbname     = "capstone2_db"; //$db_config['dbname'];
// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

if(!$conn){
    echo 'db에 연결하지 못했습니다' .mysqli_connect_error();
} else{
    echo '';
}
$sql = "SELECT * FROM msg_board";
$result = mysqli_query($conn, $sql);
$list1 = '';
$list2 = '';
$list3 = '';

// var i = 0;
// while (i <= list.length) 
 while($row = mysqli_fetch_array($result)){ // mysqli_fetch_array 배열의 형식을 출력해주는 함수
    //$row 배열 
    //문자열안에서 php변수 출력하려면 {}사용
    $list1 = $list1."<li>{$row['number']}</li>";
    $list2 = $list2."<li><a href = \"view.php?number={$row['number']}\">{$row['title']}</a><li>";
    $list3 = $list3."<li>{$row['name']}</li>";
 }
    echo   "<div class = 'board_list_wrap'>
    <div class = 'board_list'>
        <div class = 'top'>
            <div class ='num'> $list1 </div>
            <div class = 'title'>$list2</div>
            <div class = 'writer'>$list3</div>
            <div class = 'date'></div>
        </div>";
?>