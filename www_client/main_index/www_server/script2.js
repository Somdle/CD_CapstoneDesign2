async function selectHotelInfo() {
    try {
        const response = await fetch("https://main.somdle.duckdns.org/dev/capstone2/backend/select_hotel_info.php");
        const responseData = await response.json();

        if (responseData.status === 'success') {
            const hotelInfoContainer = document.getElementById("result-hotel-info");

            // 더미 이미지 URL 배열 - 각 카드에 다른 이미지가 들어갈 수 있도록 임의의 URL을 지정합니다.
            const dummyImages = [
                "image/hotel3.jpg",
                "image/hotel4.jpg",
                "image/hotel1.jpg",
                "image/hotel2.jpg",
                "https://via.placeholder.com/800x400/FF0000/FFFFFF",
                "https://via.placeholder.com/800x400/FF0000/FFFFFF",
                "https://via.placeholder.com/800x400/FF0000/FFFFFF"
            ];

            responseData.data.forEach((hotel, index) => {
                const hotelName = hotel.hotel_name;
                const hotelCharge = hotel.hotel_charge;
                const hotelIntro = hotel.hotel_intro;
                const hotelImage = dummyImages[index % dummyImages.length]; // 더미 이미지 URL 선택

                const card = document.createElement("div");
                card.classList.add("col");

                card.innerHTML = `
                    <div class="card shadow-sm">
                        <img src="${hotelImage}" class="card-img-top" alt="Hotel Image"> <!-- 더미 이미지 추가 -->
                        <div class="card-body">
                            <h5 class="card-title">${hotelName}</h5>
                            <p class="card-text">가격: ${hotelCharge}원</p>
                            <p class="card-text">${hotelIntro}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary view-btn">View</button>
                                </div>
                                <small class="text-body-secondary">9 mins</small>
                            </div>
                        </div>
                    </div>
                `;

                hotelInfoContainer.appendChild(card);

                const viewButton = card.querySelector(".view-btn");
                viewButton.addEventListener("click", () => {
                    const url = `hotel_info.html?name=${encodeURIComponent(hotelName)}&charge=${encodeURIComponent(hotelCharge)}&intro=${encodeURIComponent(hotelIntro)}`;
                    window.location.href = url;
                });
            });
        } else {
            throw new Error("데이터 처리 실패");
        }
    } catch (error) {
        console.error("오류정보: ", error);
    }
}

window.onload = selectHotelInfo;