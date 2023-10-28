async function insertForm(event) {
    event.preventDefault();  // 기본 폼 제출 동작을 막습니다.

    try {
        // 데이터 전송 후 응답을 변수에 저장
        const response = await fetch("./insert_hotel_info.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded", },
            body: new URLSearchParams({
                developerPartners:            getCheckedValue("insert-developer-partners"),
                developerPhoneNo:             phoneNoFiltered,
                developerEmail:               document.getElementById("insert-developer-email").value,
            }).toString(),
        });
        
        // 응답 확인
        if (response.ok) {
            const responseData = await response.json(); // 응답을 JSON 형태로 파싱합니다.
            if(responseData.status == 'Success'){
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
    const file = document.getElementById("insert-hotel-img").files[0];
    if (file !== undefined) {
        const formData = new FormData();

        formData.append("fileData", file);
        formData.append("fileName", file.name);
        formData.append("fileType", file.type);
        formData.append("fileSize", file.size);
    
        fetch("backend/developerDBFileUpdate.php", {
            method: "POST",
            body: formData,
        })
        .then((response) => response.text())
        .then((data) => {
            if (data === "success") {
                createToast("success", "프로필이 업로드되었습니다");
            } else {
                createToast("warning", "프로필에 문제가 있습니다");
            }
        });
    }
    else {
        console.log("선택된 이미지가 없음");
    }

}