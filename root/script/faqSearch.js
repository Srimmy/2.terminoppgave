formEl = document.getElementById("faqSearchForm");


document.body.addEventListener("click", function(e) {
    document.getElementById("faqLabel").style.display = 'block';
    if (e.target == formEl.k || formEl.k.value.length != 0) {
        document.getElementById("faqLabel").style.display = 'none';
    }

})