const btn_submit = document.querySelector('#btn_submit');

btn_submit.addEventListener("click", () => {
    btn_submit.disabled = true;

    const btn_name = document.querySelector("#id_name");
    const btn_password = document.querySelector("#id_password");
    const btn_title = document.querySelector("#id_title");

    if (btn_name.value === '') {
        alert('글쓴이를 다시 입력하세요');
        btn_name.focus();
        return false;
    }
    if (btn_password.value === '') {
        alert('비밀번호를 다시 입력하세요');
        btn_password.focus();
        return false;
    }
    if (btn_title.value === '') {
        alert('제목을 다시 입력하세요');
        btn_title.focus();
        return false;
    }

    let markupStr = $('#summernote').summernote('code');
    console.log(markupStr);

    if (markupStr === '<p><br></p>') {
        alert('내용을 입력하세요.');
        return false;
    }

    const f1 = new FormData();

    f1.append('name', id_name.value);
    f1.append('password', id_password.value);
    f1.append('subject', id_title.value);
    f1.append('content', markupStr);

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./write.php", true);
    xhr.send(f1);
    xhr.onload = () => {
        if(xhr.status == 200){ //정상적으로 처리
            alert('통신 성공')
        }
        else{
            alert(xhr.status)
        }
    }
})