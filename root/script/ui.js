let pfpEl = document.getElementById("pfpRadius");
let dropDownEl = document.getElementById("dropDown");
let invisableEl = document.getElementById("invisable");

let searchTextEl = document.getElementById("searchText");
let searchEl = document.getElementById("search");



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
    
    writeForm("../profile/profile.php", "profileForm", "otherProfile", username);
    console.log(username);
}

function follow(username) {
    writeForm("../profile/profile.php", "followForm", "followUser", username);
}
function unFollow(username) {
    writeForm("../profile/profile.php", "unFollowForm", "unFollowUser", username);
}
function deleteUser(username) {
    writeForm("../process/deleteUser.php", "deleteUserForm", "deleteUser", username);
}
function confirmDelete(username) {
    let confirmAction = confirm('Are you sure you want to delete your account?');
    if (confirmAction) {
        deleteUser(username);
    } else {
        console.log("cap");
    }
}

function seeLiked(value) {
    console.log("caps");
    invisableEl.innerHTML = ''
        + '<form action="../profile/profile.php" method ="POST" id = "likedForm">'
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



//lar ikke trykke enter hvis man ikke har skrevet noe i søkefelt
searchTextEl.addEventListener('keypress', restrictSearch);
function restrictSearch(e) {
    if (searchTextEl.value == "") {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    }
}

//fjerner enter fra profileEdit slik at man ikke kan gjøre det feil
let noEnter = [
    document.getElementById('username'), 
    document.getElementById('password'),
    newPasswordEl = document.getElementById('password'),
    document.getElementById('confirmPassword'),
  ]

for(i = 0; i < noEnter.length; i++) {
    noEnter[i].addEventListener('keydown', restrictEnter);

}
function restrictEnter(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
    }
}


function test() {
    console.log("test");
}




