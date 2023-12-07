async function selectHotelInfo() {
    try {
        
        const response = await fetch("https://main.somdle.duckdns.org/dev/capstone2/backend/select_hotel_info.php");
        const responseData = await response.json();

        if (responseData.status === 'success') {
            console.log("데이터 처리 성공");
            console.log(responseData.data);

            // 호텔 정보를 순회하면서 각 호텔의 이름, 가격, 정보를 출력함
            const hotelInfoContainer = document.getElementById("result-hotel-info");
            responseData.data.forEach(hotel => {
                const hotelName = hotel.hotel_name;
                const hotelCharge = hotel.hotel_charge;
                const hotelIntro = hotel.hotel_intro;

                // 카드 생성
                const card = document.createElement("div");
                card.classList.add("col");

                // 카드 내용 작성
                card.innerHTML = `
                    <div class="card shadow-sm">
                        <!-- 이미지 -->
                        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#55595c"/>
                            <text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
                        </svg>
                        <!-- 카드 본문 -->
                        <div class="card-body">
                            <h5 class="card-title">${hotelName}</h5>
                            <p class="card-text">가격: ${hotelCharge}원</p>
                            <p class="card-text">${hotelIntro}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                                <small class="text-body-secondary">9 mins</small>
                            </div>
                        </div>
                    </div>
                `;

               
                hotelInfoContainer.appendChild(card);
            });

            
        } else {
            throw new Error("데이터 처리 실패");
        }
    } catch (error) {
        console.error("오류정보: ", error);
    }
}


window.onload = selectHotelInfo;