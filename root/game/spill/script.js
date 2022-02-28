const knapp = document.getElementById("startSpill");
const canvas = document.getElementById("gameScreen");
const tekst = document.getElementById("scoreTekst");
const C = document.getElementById("C");
const ctx = canvas.getContext("2d");
let spill = false;

let w = 100;
let h = w / 10;
let x = 400 - w / 4;
let y = 610 - w / 4;

let ballx = Math.random() * 900 - 200;
let bally = Math.random() * 700 - 200;
let r = 30;
let speedy = 1;
let speedx = 1;
let multiSpeed = Math.round(Math.random()) * 2 - 1

let combo = 1;
let score = 0;

//Send highscore script
let SendHighscoreEl = document.getElementById("highscore");
let submitHighscoreEl = document.getElementById("submitHighscore");
let btnEl = document.getElementById("btn");

// btnEl.addEventListener("click", SendHighscore);


function SendHighscore() {
    SendHighscoreEl.value = score;
    console.log(SendHighscoreEl.value);
    submitHighscore.submit();
}


console.log("cap");
//figur
function startGame() {
    console.log("cap");
    if (spill == false) {
        spill = true;
        console.log("Start")

    }
    else {
        knapp.style.backgroundColor = "red";
        spill = true;
    }
}

// lager figuren du styrer
function figur(x, y, w, h) {
    ctx.fillStyle = "white";
    ctx.fillStyle = "red";
    ctx.fillRect(x, y, w, h);
    ctx.fillRect(x - w / 4 + w / 2, y + 10, w / 2, h / 4);
}
//lager ballen
function ball(ballx, bally,) {
    ctx.beginPath();

    ctx.fillStyle = "white";
    ctx.fillStyle = "red";
    ctx.arc(ballx, bally, r, 0, 2 * Math.PI, false);
    ctx.lineWidth = 3;
    ctx.strokeStyle = '#FF0000';
    ctx.stroke();



}
function clear() {
    ctx.beginPath();
    clearRect()
}
//Gjør at det tegnes hele tiden 

let interval = setInterval(() => {

    // treffer combo spot på figuren
    if (bally > 545 && bally < 580 && ballx > x - w / 4 + w / 2 && ballx < x + w / 2) {
        if (speedx < -3) {
            speedx = -3;
            speedx = speedx * multiSpeed;
            multiSpeed = multiSpeed * -1;
        }
        else if (speedx > 3) {
            speedx = 3;
            speedx = speedx * multiSpeed;
            multiSpeed = multiSpeed * -1;
        }
        speedy = -3;
        combo++;
        score = score + 50 * combo;
        tekst.innerHTML = "Score: " + score;
        C.innerHTML = "Combo: " + combo;

    }
    //treffer på figuren uten combo
    else if (bally > 550 && bally < 580 && speedy > 0 && ballx > x && ballx < x + w) {
        if (speedx == -2) {
            speedx = -1;
            speedx = speedx * multiSpeed;
            multiSpeed = multiSpeed * -1;
        }
        else if (speedx == 2) {
            speedx = 1;
            speedx = speedx * multiSpeed;
            multiSpeed = multiSpeed * -1;
        }
        speedy = -1;
        score = score + 50 * combo;
        tekst.innerHTML = "Score: " + score;
        C.innerHTML = "Combo: " + combo;

    }
    //treffer taket
    else if (bally < 30 && speedy < 0) {
        if (speedy == -3) {
            speedy = 3;
            multiSpeed = multiSpeed * -1;
        }
        else {
            speedy = 2;
            multiSpeed = multiSpeed * -1;
        }
    }
    else {
        bally = bally + speedy;
    }
    //treffer høyre
    if (ballx > 770 && speedx > 0) {
        if (speedx == -3) {
            speedx = 3;
            multiSpeed = multiSpeed * -1;
        }
        else {
            speedx = -2;
            multiSpeed = multiSpeed * -1;

        }

        //treffer venstre
    }
    else if (ballx < 30 && speedx < 0) {
        if (speedx == 3) {
            speedx = -3;
            multiSpeed = multiSpeed * -1;
        }
        else {
            speedx = 2;
            multiSpeed = multiSpeed * -1;

        }
    }
    else if (bally > 650) {
        //Send highscore script
        clearInterval(interval);
    }
    else {
        ballx = ballx + speedx;
    }


}, 1);



//keychecker
window.onkeydown = function (event) {
    var keyPr = event.keyCode; //Key code of key pressed

    if (keyPr === 39 && x <= 700) {
        x = x + 40; //right arrow add 20 from current
    }
    else if (keyPr === 37 && x > 10) {
        x = x - 40; //left arrow subtract 20 from current
    }


    /*clearing anything drawn on canvas
   *comment this below do draw path */
    ctx.clearRect(0, 590 - h / 4 - 5, 800, h + 25);

    //Drawing rectangle at new position
    figur(x, y, w, h);

};






knapp.addEventListener("click", startGame); 


setInterval(() => {
    ctx.fillStyle = "black";

    ctx.clearRect(ballx - 1.57 * r, bally - 1.57 * r, 80, 80);
    //ctx.clearRect(ballx-2*r, bally-2*r, 4*r +20, 4*r +20);
    ball(ballx, bally);




}, 2);





