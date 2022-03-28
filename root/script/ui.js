//la til readonly attribute slik at det ikke kan endres

let pfpEl = document.getElementById("pfpRadius");
let dropDownEl = document.getElementById("dropDown");
let invisableEl = document.getElementById("invisable");

let searchTextEl = document.getElementById("searchText");
let searchEl = document.getElementById("search");

//modal
let modalButtonEl = document.getElementById('modalButton');
let modalParentEl = document.getElementById('modalParent');
let modalChildEl = document.getElementById('modalChild');
let uploadPictureEl = document.getElementById('uploadPicture');

console.log(modalButtonEl);
modalButtonEl.addEventListener("click", showModal);

function showModal() {
    modalParentEl.style.display = 'block';
    modalChildEl.style.animation = 'modalIntro 0.02s';
}

function hideModal(e) {
    console.log(e.target.id);
    if(e.target.id == 'modalParent') {
        modalParentEl.style.display = 'none';
    }
    console.log(e.target.id);
}

document.body.addEventListener("click", pfpDropdown)
dropDownEl.style.display = "none"

//hvorfor må jeg trykke 1 gang på skjermen før jeg kan trykke på profilbildet?
//svar: js endrer ikke css, de endrer <style> tag i html ved å legge til et tagg.
// man må ha style display none i html filen ikke i css
function pfpDropdown(e) {
    if (dropDownEl.style.display === "none" && (e.target.id == "drop" || e.target.id == "pfpradius")) {
        dropDownEl.style.display = "flex";
    } else {
        dropDownEl.style.display = "none";
    };
}

document.body.addEventListener('click', searchExpansion);

function searchExpansion(e) {
    if (searchEl.style.width == "15vw" && (e.target.id == 'search' || e.target.id == 'searchText' || e.target.id == 'søkeBildet')) {
        searchEl.style.width = "30vw";
    } else if (!(e.target.id == 'search')) {
        if (!(e.target.id == 'searchText')) {
            if (!(e.target.id == 'søkeBildet')) {
                searchEl.style.width = "15vw"
            }
        }
    }
        //gjør at man går til søkefeltet (inputen)
    if (e.target.id == 'søkeBildet' || e.target.id == 'search') {
        searchTextEl.focus();
        searchTextEl.select();

    }

}


//MÅ HA INVISABLE ID PÅ EN DIV FOR AT DENNE SKAL FUNKE
//får en error dersom jeg endrer bare bruker writeForm istedet for 2 funksjoner
//fant ut at jeg ikke kan ha 2 paremeter i php når jeg har en onclick function
function sendTilProfil(username) {
    
    writeForm("../profile/profile.php", "profileForm", "otherProfile", username, "username", "get");
    console.log(username);
}

function follow(username) {
    writeForm("../profile/profile.php", "followForm", "followUser", username, "username", "get");
}
function unFollow(username) {
    writeForm("../profile/profile.php", "unFollowForm", "unFollowUser", username, "username", "get");
}
function deleteUser(username) {
    writeForm("../process/deleteUser.php", "deleteUserForm", "deleteUser", username, "username", "post");
}
function confirmDelete(username) {
    let confirmAction = confirm('Are you sure you want to delete your account?');
    if (confirmAction) {
        deleteUser(username);
    } else {
        console.log("cap");
    }
}
function seeTicket(id) {
    console.log("cap");
    writeForm("../costumerSupport/answerTicket.php", "seeTicketForm", "seeTicket", id, "id", "get");
}

function seeLiked(value, username) {
    console.log("caps");
    invisableEl.innerHTML = ''
        + '<form action="../profile/profile.php" method ="get" id = "likedForm">'
        + '<input class = "invisable" type = "text" name = "liked" value ="' + value + '">'
        + '<input class = "invisable" type = "text" name = "username" value = "'+ username+'">'
        + ' </form>';
    document.getElementById("likedForm").submit();

}
//kan endre denne funksjonen slik at den blir universell etterhvert
//da denne var document.write ble det flasha uten css
function writeForm(php, id, name, value, postName, method) {
    invisableEl.innerHTML = ''
        + '<form action="' + php + '" method ="'+method+'" id = "' + id + '">'
        + '<input class = "invisable" type="text" name = '+ postName+' value=' + value + '>'
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



//lar ikke trykke enter hvis man ikke har skrevet noe i søkefelt
searchTextEl.addEventListener('keypress', restrictSearch);
function restrictSearch(e) {
    if (searchTextEl.value == "") {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    }
}

uploadPictureEl.disabled = true;
//live preview av bildet når man velger path i modalen
function showPreview(event){
    if(event.target.files.length > 0){
      var src = URL.createObjectURL(event.target.files[0]);
      var preview = document.getElementById("picturePreview");
      preview.src = src;
      preview.style.display = "block";
      uploadPictureEl.disabled = false;
      uploadPictureEl.style.cursor = "pointer";
      uploadPictureEl.style.color = "#149df7";
    }
  }


function test() {
    console.log("test");
}





