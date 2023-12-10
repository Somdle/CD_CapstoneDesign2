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
    echo 'DB에 연결하지 못했습니다' .mysqli_connect_error();
} else {
    echo "<script>alert('등록되었습니다.');";
    echo "window.location.href = 'index.html';</script>"; // index.html로 자동 이동
}

$user_name = $_POST['name']; // 입력한 값 변수에 저장
$user_msg = $_POST['message']; // 입력한 값 변수에 저장
$use_title = $_POST['title']; // 입력한 값 변수에 저장

$sql = "INSERT INTO msg_board (name, message, title) VALUES ('$user_name','$user_msg','$use_title')"; // 테이블에 데이터 입력
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>