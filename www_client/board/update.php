
<?php
$conn = mysqli_connect("localhost", "root", "", "abc_corp");

if ($conn->connect_error) {
    die("접속 실패: " . $conn->connect_error);
}

$view_num = isset($_GET['number']) ? (int)$_GET['number'] : 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 사용자가 폼을 제출한 경우
    $name = $_POST['name'];
    $message = $_POST['message'];
    $title = $_POST['title'];

    // UPDATE 쿼리에서 $view_num을 사용하기 전에 정의
$sql_update = "UPDATE msg_board SET name='$name', title='$title', message='$message' WHERE number=$view_num";
    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('게시판이 수정되었습니다.');</script>";
    } else {
        echo "수정 오류: " . $conn->error;
    }
   
}

$sql_select = "SELECT * FROM msg_board WHERE number = $view_num";
$result_select = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 수정</title>
</head>
<body>
    <?php
    if ($result_select->num_rows > 0) {
        while ($row = $result_select->fetch_assoc()) {
            
    ?>
            <h1>수정하기</h1>
            <form action="" method="post"> 
                 <p>
                    <label for="title">제목:</label>
                    <input type="text" id="title" name="title" value="<?= $row['title'] ?>">
                </p>
                <p>
                    <label for="name">이름:</label>
                    <input type="text" id="name" name="name" value="<?= $row['name'] ?>">
                </p>
                <p>
                    <label for="message">메세지:</label>
                    <textarea name="message" id="message" cols="30" rows="10"><?= $row['message'] ?></textarea>
                </p>
                <input type="submit" value="수정하기">
                <p><a href = "list.php">게시판 돌아가기</a></p>
            </form>
    <?php 
        }
    } 
    $conn->close();
    ?> 
</body>
</html> 