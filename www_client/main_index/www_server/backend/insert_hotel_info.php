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

// 파일정보 처리
if(isset($_FILES['fileData'])){
    $fileDataEncoded = mysqli_real_escape_string($conn, base64_encode(file_get_contents($_FILES["fileData"]["tmp_name"])));

    $fileName = isset($_POST["fileName"])  ? mysqli_real_escape_string($conn, $_POST["fileName"]) : null;
    $fileType = isset($_POST["fileType"])  ? mysqli_real_escape_string($conn, $_POST["fileType"]) : null;
    $fileSize = isset($_POST["fileSize"])  ? mysqli_real_escape_string($conn, $_POST["fileSize"]) : null;
}

// 기타정보 처리
$hotelName   = isset($_POST["hotelName"])   ? mysqli_real_escape_string($conn, $_POST["hotelName"])   : null;
$hotelCharge = isset($_POST["hotelCharge"]) ? mysqli_real_escape_string($conn, $_POST["hotelCharge"]) : null;
$hotelIntro  = isset($_POST["hotelIntro"])  ? mysqli_real_escape_string($conn, $_POST["hotelIntro"])  : null;

// 트랜잭션 시작
$conn->begin_transaction();

try {
    // SQL 쿼리 작성 및 실행
    $sql  = "INSERT INTO hotel_info_table (hotel_name, hotel_charge, hotel_intro) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sis", $hotelName, $hotelCharge, $hotelIntro);
    $stmt->execute();

    // 쿼리 성공여부 확인
    if ($stmt->affected_rows > 0) {
        $hotel_id = $conn->insert_id; // 방금 추가된 데이터의 hotel_id를 받아옵니다.

        // SQL 쿼리 작성 및 실행
        $sql = "INSERT INTO hotel_img_table (hotel_id, hotel_img) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $hotel_id, $fileDataEncoded);
        $stmt->execute();

        // 쿼리 성공여부 확인
        if ($stmt->affected_rows > 0) {
            // 모든 작업이 성공하면 트랜잭션 커밋
            $conn->commit();
        } else {
            throw new Exception("이미지 데이터 처리 실패: " . $stmt->error);
        }
    } else {
        throw new Exception("데이터 처리 실패: " . $stmt->error);
    }
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
echo json_encode(array("status" => "success", "message" => "삽입 성공"));
exit();