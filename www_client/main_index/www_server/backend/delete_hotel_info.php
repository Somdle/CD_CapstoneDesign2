<?php
// CORS 설정
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, X-Requested-With");

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

// 기타정보 처리
$hotelName   = isset($_POST["hotelName"])   ? mysqli_real_escape_string($conn, $_POST["hotelName"])   : null;


try {
    // 트랜잭션 시작
    $conn->begin_transaction();

    // SQL 쿼리 작성 및 실행
    $sql = "DELETE FROM hotel_img_table
            WHERE hotel_id IN (
                SELECT hotel_id FROM hotel_info_table WHERE hotel_name = ?
            );";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $hotelName);
    $stmt->execute();
    //쿼리 성공 여부 확인
    if (!($stmt->affected_rows > 0)) {
        throw new Exception("이미지 정보 처리 실패: " . $stmt->error);
    }

    // SQL 쿼리 작성 및 실행
    $sql = "DELETE FROM hotel_info_table
            WHERE hotel_name = ?;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $hotelName);
    $stmt->execute();
    //쿼리 성공 여부 확인
    if (!($stmt->affected_rows > 0)) {
        throw new Exception("호텔 정보 처리 실패: " . $stmt->error);
    }

    // 완료시 커밋
    $conn->commit();

} catch (Exception $e) {
    // 작업 중 에러가 발생하면 트랜잭션 롤백
    $conn->rollback();

    $stmt->close();
    $conn->close();

    echo json_encode(array("status" => "error", "message" => $e->getMessage()));
    exit();
}

// 연결 종료
$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode(array("status" => "success", "message" => "제거 성공"));
exit();