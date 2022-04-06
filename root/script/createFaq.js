outputEl = document.getElementById("newInputs");
formEl = document.getElementById("form");
function addInputs() {
    //skjer når man endrer antall linjer
    outputEl.innerHTML = "";
    switch (formEl.pictureAmount.valye) {
        case 0: // du har skrevet inn 0
            break;
        default: // tallet er over 0 (min 0 på input felt)
            outputEl.innerHTML += "The number represents which line the picture will be on <br>";
            for (i = 0; i < formEl.pictureAmount.value; i++) {
                //skriver alle inputfelt
                outputEl.innerHTML += "#"+parseInt(i+1)+"<input type='file' name ='file[]'> <br>";
            }
            break;
    }



}