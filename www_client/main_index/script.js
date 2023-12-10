const API_KEY = 'f5abc4ea0e4ec8c2d04e95bf2584244a';
const weatherWidget = document.getElementById('weatherWidget');

// OpenWeatherMap API 호출 함수
async function fetchWeather() {
  try {
    const response = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=Daejeon&appid=${API_KEY}&units=metric`);
    const data = await response.json();
    displayWeather(data);
  } catch (error) {
    console.log('날씨 정보를 불러오지 못했습니다.', error);
  }
}

// 날씨 정보 표시 함수
function displayWeather(data) {
  const temperature = data.main.temp;
  const weatherDescription = data.weather[0].description;
  const windSpeed = data.wind.speed;
  const humidity = data.main.humidity;
  const icon = `http://openweathermap.org/img/wn/${data.weather[0].icon}.png`;

  const weatherHTML = `
    <div class="d-flex">
      <h6 class="flex-grow-1"></h6>
      <h6></h6>
    </div>
    <div class="d-flex flex-column text-center mt-5 mb-4">
      <h4>현재 대전 날씨</h4>
      <h6 class="display-4 mb-0 font-weight-bold" style="color: #1C2331;">${temperature}°C</h6>
      <span class="small" style="color: #868B94">${weatherDescription}</span>
    </div>
    <div class="d-flex align-items-center">
      <div class="flex-grow-1" style="font-size: 1rem;">
        <div><i class="fas fa-wind fa-fw" style="color: #868B94;"></i> <span class="ms-1">${windSpeed} km/h</span></div>
        <div><i class="fas fa-tint fa-fw" style="color: #868B94;"></i> <span class="ms-1">${humidity}%</span></div>
      </div>
      <div>
        <img src="${icon}" width="100px">
      </div>
    </div>
  `;

  weatherWidget.innerHTML = weatherHTML;
}

// 페이지 로드 시 날씨 정보 가져오기
window.onload = fetchWeather;