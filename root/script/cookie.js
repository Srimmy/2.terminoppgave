const cookieContainerEl = document.querySelector(".cookie-container");
const cookieBtnEl = document.querySelector(".cookie-btn");
const TOSEl = document.getElementById("TOS");
const TOSBtnEl = document.getElementById('TOS-btn');
const TOSmodalEl = document.querySelector(".TOS-modal");


//aksepterer TOS
cookieBtnEl.addEventListener("click", accepted); 
TOSBtnEl.addEventListener("click", accepted);
//viser og skjuler TOS
TOSEl.addEventListener("click", showTOS);
TOSmodalEl.addEventListener("click", (e) => {
    if(e.target.id == 'TOSparent') {
        TOSmodalEl.classList.remove("active");
    }
})
function showTOS() {
    TOSmodalEl.classList.add("active");
}
function accepted(){
    //skjer når cookie knapp trykkes
    cookieContainerEl.classList.remove("active");
    localStorage.setItem("cookieBannerDisplayed", "true")
    TOSmodalEl.classList.remove("active");
}

//cookie popup
setTimeout(() => {
    if (!localStorage.getItem("cookieBannerDisplayed")) {
        cookieContainerEl.classList.add("active")
    }
}, 2000);
