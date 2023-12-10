<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>insert</title>
</head>
<body>
    
</body>
</html>
<?php
$conn = mysqli_connect("localhost", "root", "12345", "abc_corp"); //DB연결

if(!$conn){
    echo 'db에 연결하지 못했습니다' .mysqli_connect_error();
} else{
    echo 'db에 접속 하였습니다';
}
$user_name = $_POST['name'];//입력한값 변수에 저장
$user_msg = $_POST['message']; // 입력한값 변수에저장

$sql = "INSERT INTO msg_board (name, message) VALUES ('$user_name','$user_msg')"; //테이블에 데이터 입력
$result = mysqli_query($conn, $sql);

if($result === false){
    echo '저장하지 못했습니다';
    error_log(mysqli_error($conn));//왜 저장하지 못했는지 애러코드 보여줘 애러로그 기록
}else{
    echo '저장 성공';
}
mysqli_close($conn);
print "<hr/><a href = 'index.html'>메인화면으로 이동하기</a>";
?>