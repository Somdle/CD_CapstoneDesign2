
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>
    <link rel="stylesheet" href="write_style.css">
</head>
<body>
    <div class="board_wrap">
        <div class="board_title">
            <strong>대전 여행 친구찾기</strong>
            <p>대전 여행 친구를 찾기 위해 글을 올려보세요!!</p>
        </div>
    <form action = "insert.php" method= "post"> 
        <div class="board_write_wrap">
            <div class="board_write">
                <div class="title">
                    <dl>
                        <dt> <label for="title">제목</label></dt>
                        <dd>  <input type="text" id = "title" name = "title" placeholder="제목 입력"></dd>
                    </dl>
                </div>
                <div class="info">
                    <dl>
                        <dt> <label for="name">이름</label></dt>
                        <dd> <input type="text" id = "name" name = "name" placeholder="이름 입력"></dd>
                    </dl>
                </div>
                <div class="cont">
                    
            <textarea name= "message" id= "message" placeholder="내용 입력"></textarea></textarea>
                </div>
            </div>
            <div class="bt_wrap">
                <input  class = "write_btn"  type = "submit" value = "글쓰기">
                <a href="index.html" class = "on">취소</a>
            </div>

        </div>
    </div>
    </form>
</body>
</html>