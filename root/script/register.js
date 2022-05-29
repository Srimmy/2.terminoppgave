let formEl = document.getElementById("loginForm");

window.onload = () => {
    if(!(formEl.username.value = ''))  {
        formEl.username.classList.add("focus");
        formEl.username.classList.add("valid");
    }
}
