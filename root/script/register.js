let registerUserEl = document.getElementById('registerUser');
let registerPasswordEl = document.getElementById("registerPassword");
let registerSubmitEl = document.getElementById("registerSubmit");

//login
registerUserEl.addEventListener('keydown', registerCheck);
registerPasswordEl.addEventListener('keydown', registerCheck);

// function registerCheck() {
//     console.log("test");
//     if(!(registerUserEl.value.length > 2) || !(registerPasswordEl.value.length > 2)) {
//         registerSubmitEl.style.opacity = '0.5';
//         registerSubmitEl.disabled = true;
//     } else {
//         registerSubmitEl.style.opacity = '1';
//         registerSubmitEl.disabled = false;
//     }
// }