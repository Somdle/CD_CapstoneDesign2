<!DOCTYPE html>
<html>
<body>
<h2> 데이터 출력 예제 </h2>

<?php
$conn = mysqli_connect("localhost", "root", "12345", "abc_corp"); // DB 연결 localhost로 접속해야함

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
        echo "글번호: " . $row["number"] . " / 글쓴이: " . $row["name"] . " / 내용: " . $row["message"] . "<br>";
    }
} else {
    echo "해당하는 데이터가 없습니다.";
}

$conn->close();
?>

</body>
</html>