async function insertForm(event) {
    event.preventDefault();  // 기본 폼 제출 동작을 막습니다.

    // 선택정보 업로드
    try {
        // 데이터 전송 후 응답을 변수에 저장
        const response = await fetch("./backend/insert_hotel_info.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded", }, // 간단한 텍스트 데이터
            body: new URLSearchParams({
                hotelName:   document.getElementById("insert-hotel-name").value,
                hotelCharge: document.getElementById("insert-hotel-charge").value,
                hotelIntro:  document.getElementById("insert-hotel-intro").value,
            }).toString(),
        });
        
        // 응답 확인
        if (response.ok) {
            const responseData = await response.json(); // 응답을 JSON 형태로 파싱합니다.
            if(responseData.status == 'success'){
                console.log("데이터 처리 성공")
            } else {
                throw new Error("데이터 처리 실패");
            }
        } else {
            throw new Error("서버 응답 에러");
        }
    } catch (error) {
        console.error("오류정보: ", error);
        return false;
    }

    // 이미지 업로드
    try {
        // 전송할 파일 가져오기 및 파일 여부 확인
        const file = document.getElementById("insert-hotel-img").files[0];
        if(file === undefined){
            throw new Error("파일이 존재하지 않음");
        }

        // 전송할 데이터 폼 생성
        const formData = new FormData();

        // 데이터 폼에 파일 정보 추가
        formData.append("fileData", file);
        formData.append("fileName", file.name);
        formData.append("fileType", file.type);
        formData.append("fileSize", file.size);

        // 데이터 전송 후 응답을 변수에 저장
        const response = await fetch("./backend/insert_hotel_info_image.php", {
            method: "POST",
            // headers: { "Content-Type": "multipart/form-data", }, // 파일이나 비 ASCII 데이터, 큰 양의 바이너리 데이터 등을 전송 (여기선 필요하지 않음)
            body: formData,
        });
        
        // 응답 확인
        if (response.ok) {
            const responseData = await response.json(); // 응답을 JSON 형태로 파싱합니다.
            if(responseData.status == 'success'){
                console.log("데이터 처리 성공")
            } else {
                throw new Error("데이터 처리 실패");
            }
        } else {
            throw new Error("서버 응답 에러");
        }
    } catch (error) {
        console.error("오류정보: ", error);
        return false;
    }

}