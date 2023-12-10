<link rel = "stylesheet" href="board2.css">
<?php
$conn = mysqli_connect("localhost", "root", "12345", "abc_corp");

if(!$conn){
    echo 'db에 연결하지 못했습니다' .mysqli_connect_error();
} else{
    echo 'db에 접속 하였습니다';
}
$sql = "SELECT * FROM msg_board";
$result = mysqli_query($conn, $sql);
$list = '';

// var i = 0;
// while (i <= list.length) 
 while($row = mysqli_fetch_array($result)){ // mysqli_fetch_array 배열의 형식을 출력해주는 함수
    //$row 배열 
    //문자열안에서 php변수 출력하려면 {}사용
    $list = $list."<li class = 'top'>{$row['number']}: <a href = \"view.php?number={$row['number']}\">{$row['name']}</a></li>";
 }
    echo  $list;
?>