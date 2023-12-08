<!DOCTYPE html>
<html>
<link rel = "stylesheet" href="board3.css">
<body>

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
// 접속 체크
if ($conn->connect_error) {
    die("접속 실패: " . $conn->connect_error);
}

// 사용자로부터의 입력값 확인
$view_num = isset($_GET['number']) ? (int)$_GET['number'] : 0;

// 특정 number에 해당하는 데이터 출력
$sql_select = "SELECT * FROM msg_board WHERE number = $view_num";
$result_select = $conn->query($sql_select);

if ($result_select->num_rows > 0) {
    // 결과 집합에 행이 있는 경우
    while ($row = $result_select->fetch_assoc()) {
        echo " <div class = 'board_list_wrap'>
        <div class = 'board_view'>
            <div class = 'title'>

            </div>
            <div class = 'info'>
                <dl>
                    <dt>번호</dt>
                    <dd>" . $row['number'] . "</dd>
                </dl>
                <dl>
                    <dt>글쓴이</dt>
                    <dd>" . $row['name'] . "</dd>
                </dl>
                <dl>
                    <dt>작성일</dt>
                    <dd></dd>
                </dl>
            </div>
            <div class ='cont'>
                " . $row['message'] . " 
            </div>
        </div>
     </div>";  
     // ..은 {}역할

        // 수정 링크 생성
        echo "<div class = 'bt_wrap'>
                 <a href='list.php' class = 'on'>목록</a>
                 <a href='update.php?number={$row['number']}' class = 'on'>수정</a>
            </div>";
    }
} else {
    echo "해당하는 데이터가 없습니다.";
}

$conn->close();
?>
 
</body>
</html>