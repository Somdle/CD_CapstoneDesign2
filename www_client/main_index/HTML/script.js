var table = document.querySelector('table');
var link = document.querySelector('.li1'); // "추천루트" 링크

// "추천루트" 링크를 클릭했을 때 이벤트 처리
link.addEventListener('click', function(event) {
    event.preventDefault(); // 기본 링크 동작 방지
    table.style.display = 'table'; // 테이블을 표시
});