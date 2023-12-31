async function insertHotelInfo(event) {
    event.preventDefault();  // 기본 폼 제출 동작을 막습니다.

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

        // 데이터 폼에 텍스트 정보 추가
        formData.append("hotelName",   document.getElementById("insert-hotel-name").value);
        formData.append("hotelCharge", document.getElementById("insert-hotel-charge").value);
        formData.append("hotelIntro",  document.getElementById("insert-hotel-intro").value);

        // 데이터 전송 후 응답을 변수에 저장
        const response = await fetch("https://main.somdle.duckdns.org/dev/capstone2/backend/insert_hotel_info.php", {
            method: "POST",
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


async function selectHotelInfo(event) {
    event.preventDefault();  // 기본 폼 제출 동작을 막습니다.

    try {
        // 전송할 데이터 폼 생성
        const formData = new FormData();

        // 데이터 폼에 텍스트 정보 추가
        formData.append("hotelName",   document.getElementById("select-hotel-name").value);
        formData.append("hotelCharge", document.getElementById("select-hotel-charge").value);
        formData.append("hotelIntro",  document.getElementById("select-hotel-intro").value);

        // 데이터 전송 후 응답을 변수에 저장
        const response = await fetch("https://main.somdle.duckdns.org/dev/capstone2/backend/select_hotel_info.php", {
            method: "POST",
            body: formData,
        });
        
        // 응답 확인
        if (response.ok) {
            const responseData = await response.json(); // 응답을 JSON 형태로 파싱합니다.
            if(responseData.status == 'success'){
                console.log("데이터 처리 성공");
                console.log(responseData.data); // 받은 데이터를 콘솔에 출력
                
                document.getElementById("result-hotel-data").innerHTML = JSON.stringify(responseData.data, null, 2);              
                document.getElementById("result-hotel-img").src = "data:image/png;base64," + responseData.data[0].hotel_img; // 인코딩된 이미지 데이터 적용
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

async function deleteHotelInfo(event) {
    event.preventDefault();  // 기본 폼 제출 동작을 막습니다.

    try {
        // 전송할 데이터 폼 생성
        const formData = new FormData();

        // 데이터 폼에 텍스트 정보 추가
        formData.append("hotelName",   document.getElementById("delete-hotel-name").value);

        // 데이터 전송 후 응답을 변수에 저장
        const response = await fetch("https://main.somdle.duckdns.org/dev/capstone2/backend/delete_hotel_info.php", {
            method: "POST",
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