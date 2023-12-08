<link rel = "stylesheet" href="board2.css">
<?php
$conn = mysqli_connect("192.168.152.62", "root", "", "abc_corp");

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