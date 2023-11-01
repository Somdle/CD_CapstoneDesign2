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

// 받은 값 처리
$hotelName   = isset($_POST["hotelName"])   ? mysqli_real_escape_string($conn, $_POST["hotelName"])   : null;
$hotelCharge = isset($_POST["hotelCharge"]) ? mysqli_real_escape_string($conn, $_POST["hotelCharge"]) : null;
$hotelIntro  = isset($_POST["hotelIntro"])  ? mysqli_real_escape_string($conn, $_POST["hotelIntro"])  : null;

// 기본 SQL 쿼리
$sql = "SELECT * FROM hotel_info_table";

// WHERE 절을 위한 배열
$where = array();

// 각 필드에 대해 null이 아닌 경우 WHERE 절에 추가
if ($hotelName !== null) {
    $where[] = "hotel_name = ?";
}
if ($hotelCharge !== null) {
    $where[] = "hotel_charge = ?";
}
if ($hotelIntro !== null) {
    $where[] = "hotel_intro = ?";
}

// WHERE 절이 있는 경우 SQL 쿼리에 추가
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

// SQL 쿼리 준비
$stmt = $conn->prepare($sql);

// WHERE 절이 있는 경우 파라미터 바인딩
if (!empty($where)) {
    $types = "";
    $params = array();
    if ($hotelName !== null) {
        $types .= "s";
        $params[] = &$hotelName;
    }
    if ($hotelCharge !== null) {
        $types .= "i";
        $params[] = &$hotelCharge;
    }
    if ($hotelIntro !== null) {
        $types .= "s";
        $params[] = &$hotelIntro;
    }
    array_unshift($params, $types);
    call_user_func_array(array($stmt, 'bind_param'), $params);
}

// SQL 쿼리 실행
$stmt->execute();

// 결과를 저장할 배열
$data = array();

// 결과 가져오기
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    // 각 행을 배열에 추가
    $data[] = $row;
}

// status와 데이터를 포함하는 배열 생성
$response = array(
    'status' => 'success', // status 추가
    'data' => $data
);

// 배열을 JSON으로 변환하고 출력
header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT); // 수정된 부분
