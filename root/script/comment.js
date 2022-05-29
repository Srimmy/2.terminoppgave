//comment modal
let commentModalParentEl = document.getElementById("commentModalParent");

commentModalParentEl.addEventListener("click", (e) => {
    if(e.target.id == 'commentModalParent') {
        window.location.href = "../browse/browse.php";
    }
})