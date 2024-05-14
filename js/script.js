document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById('searchInput');
    var suggestions = document.querySelector(".suggestions");

    function handleSearch() {
        var searchTerm = searchInput.value.toLowerCase();
        var searchText = searchInput.value.trim();
        if (searchText !== "") {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "search.php?q=" + encodeURIComponent(searchText), true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    suggestions.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    }

    searchInput.addEventListener('input', handleSearch);
});

var oppskrifter = document.getElementsByClassName("recipie");

function visOppskrifter(kategori_id) {
    for (var i = 0; i < oppskrifter.length; i++) {
        oppskrifter[i].style.display = "none";
    }
    if (kategori_id == 'alle') {
        for (var i = 0; i < oppskrifter.length; i++) {
            oppskrifter[i].style.display = "block";
        }
    } else {
        for (var i = 0; i < oppskrifter.length; i++) {
            if (oppskrifter[i].getAttribute("data-kategori-id") == kategori_id) {
                oppskrifter[i].style.display = "block";
            }
        }
    }
}

window.onload = function () {
    visOppskrifter('alle');
};

var kategorierDiv = document.getElementsByClassName("matkategori");
for (var i = 0; i < kategorierDiv.length; i++) {
    kategorierDiv[i].addEventListener("click", function () {
        visOppskrifter(this.getAttribute("data-kategori-id"));
    });
}
