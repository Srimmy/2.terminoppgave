let pfpEl = document.getElementById("pfpRadius");
let dropDownEl = document.getElementById("dropDown");
let invisableEl = document.getElementById("invisable");


document.body.addEventListener("click", pfpDropdown)
dropDownEl.style.display = "none"

//hvorfor må jeg trykke 1 gang på skjermen før jeg kan trykke på profilbildet?
function pfpDropdown(e) {
    if (dropDownEl.style.display === "none" && (e.target.id == "drop" || e.target.id == "pfpradius")) {
        dropDownEl.style.display = "flex";
    } else {
        dropDownEl.style.display = "none";
    };
}


//får en error dersom jeg endrer bare bruker writeForm istedet for 2 funksjoner
//fant ut at jeg ikke kan ha 2 paremeter i php når jeg har en onclick function
function sendTilProfil(username) {
    writeForm("profile.php", "profileForm", "otherProfile", username);
}

function follow(username) {
    writeForm("profile.php", "followForm", "followUser", username);
}
function unFollow(username) {
    writeForm("profile.php", "unFollowForm", "unFollowUser", username);


}
function seeLiked(value) {
    console.log("caps");
    invisableEl.innerHTML = ''
        + '<form action="profile.php" method ="POST" id = "likedForm">'
        + '<input class = "invisable" type = "text" name = "liked" value ="' + value + '">'
        + ' </form>';
    document.getElementById("likedForm").submit();

}
//kan endre denne funksjonen slik at den blir universell etterhvert
//da denne var document.write ble det flasha uten css
function writeForm(php, id, name, username) {
    invisableEl.innerHTML = ''
        + '<form action="' + php + '" method ="POST" id = "' + id + '">'
        + '<input class = "invisable" type="text" name = "username" value=' + username + '>'
        + '<input class = "invisable" type = "text" name = "' + name + '" value ="0">'
        + ' </form>';
    document.getElementById(id.toString()).submit();
}


//restrction av post button i kommentarfelt

let postEl = document.getElementsByName('newComment');
let submitEl = document.getElementsByName('submitComment');
console.log(postEl);

//hvis jeg har lyst til å legge til noe med buttons i following
// function test(innleggNr) {
//     submitEl[innleggNr].disabled = "true";
//     if (!(postEl[innleggNr].value === "")) {
//         submitEl[innleggNr].disable = "false";
//         console.log("clapped");
//     } else {
//         console.log(submitEl[innleggNr]);
//         console.log(postEl[innleggNr]);
//     }

// }

//like funksjon basert på koden over
let likeEl = document.getElementsByName('like');
console.log(likeEl);
function like(bildeId) {
    invisableEl.innerHTML = ''
        + '<form action="following.php" method ="POST" id = "likeForm">'
        + '<input class = "invisable" type="text" name = "bildeId" value=' + bildeId + '>'
        + '<input class = "invisable" type = "text" name = "like" value ="0">'
        + ' </form>';
    document.getElementById("likeForm").submit();
}