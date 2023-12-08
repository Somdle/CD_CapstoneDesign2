<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<link rel = "stylesheet" href="board2.css">
<?php
$conn = mysqli_connect("localhost", "root", "", "abc_corp");

if(!$conn){
    echo 'db에 연결하지 못했습니다' .mysqli_connect_error();
} else{
    echo 'db에 접속 하였습니다';
}
$user_delnum =$_POST['delnum']; //POST 방식 delnum으로 넘어온걸 delnum 저장
$sqlDEL = "DELETE  FROM msg_board WHERE number = $user_delnum";
$result = mysqli_query($conn, $sqlDEL);
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
    mysqli_close($conn);
?>
<?php
    echo $user_delnum. '번째 게시물이 삭제 되었습니다'
?>
</body>
</html>