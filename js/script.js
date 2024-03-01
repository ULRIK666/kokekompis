document.addEventListener("DOMContentLoaded", function () {
    var menuIcon = document.querySelector('.menu-icon');
    var dropdownContent = document.querySelector('.dropdown-content');
    var searchInput = document.getElementById('searchInput');

    menuIcon.addEventListener('mouseover', function () {
        dropdownContent.style.display = 'block';
    });

    menuIcon.addEventListener('mouseout', function () {
        dropdownContent.style.display = 'none';
    });

    // Handle search logic
    searchInput.addEventListener('input', function () {
        var searchTerm = searchInput.value.toLowerCase();
        var links = dropdownContent.getElementsByTagName('a');

        for (var i = 1; i < links.length; i++) { // Start from index 1 to skip the search input itself
            var linkText = links[i].innerText.toLowerCase();
            if (linkText.includes(searchTerm)) {
                links[i].style.display = 'block';
            } else {
                links[i].style.display = 'none';
            }
        }
    });
});


document.addEventListener("DOMContentLoaded", function () {
    var searchInput = document.getElementById("searchInput");
    var suggestions = document.querySelector(".suggestions");

    document.getElementById("searchButton").addEventListener("click", function () {
        var searchText = searchInput.value.trim();
        if (searchText !== "") {
            // Utfør AJAX-forespørsel for å hente oppskrifter basert på søketeksten
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "search.php?q=" + encodeURIComponent(searchText), true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Fjern eksisterende oppskrifter
                    suggestions.innerHTML = "";
                    // Legg til nye oppskrifter
                    suggestions.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    });
});