<?php
/****************************************************************
 * 기능: 비 정상 접근 차단, JSON 데이터 변환
 * 설명: 사용자가 로그인 되어 있지 않은 경우 로그인 페이지로 리다이렉트
 ****************************************************************/
if($_SERVER["REQUEST_METHOD"] != "POST"){ // post 통신이 아니면
    echo "<script>location.replace('index.php');</script>";
    die("비정상접근");
}

/****************************************************************
 * 기능: 데이터베이스 관련
 * 설명: 
 ****************************************************************/
//절대경로로 접근, Nginx에 DB정보가 미리 준비되어 있어야함
$db_config = parse_ini_file('/config/nginx/db_config.ini');

// MySQL 데이터베이스 연결 정보
$servername = $db_config['host'];
$username   = $db_config['username'];
$password   = $db_config['password'];
$dbname     = "capstone2_db"; //$db_config['dbname'];

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);