let outputEl = document.getElementById("newInputs");
let formEl = document.getElementById("form");

formEl.contents.addEventListener('keyup', addInputs);

function addInputs() {
    outputEl.innerHTML = "";
    let inputArray = formEl.contents.value.split('');
    let lines = 1;
    for (i = 0; i < inputArray.length; i++) {
        if (inputArray[i] == '*') {
            //hver gang ny linje skal skrives
            lines++;
        }
    }
    if (lines > 0) {
        outputEl.innerHTML += "The number represents which line the picture will be on <br>";
    }
    for (i = 0; i < lines; i++) {
        outputEl.innerHTML += "#" + parseInt(i + 1) + "<input type='file' name ='file[]'> <br>";
    }
}



