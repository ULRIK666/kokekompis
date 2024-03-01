<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kokekompis</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <div>
            <div class="menu-container">
                <img class="img-icon menu-icon" src="images/icon-img/menu_icon.png" alt="menu icon">
                <div class="dropdown-content">

                    <a href="faq.php">FAQ</a>
                    <a href="log_inn.php">Log In</a>
                    <a href="signup.php">Sign Up</a>
                </div>
            </div>
            <a href="index.php"><img class="logo" src="images/logo/kokekompis.png" alt="menu icon"></a>
        </div>
        <div class="space_between">
            <div class="search_and_suggestions">
                <div class="søke_input">
                    <div class="space_between">
                        <button id="searchButton" style="border: none; background: none; padding: 0;"><img
                                class="img-icon" src="images/icon-img/search_icon.png" alt="søke ikon"></button>
                        <input type="text" id="searchInput" placeholder="Søk etter oppskrift">
                        <div id="searchSuggestions" class="search-suggestions"></div> <!-- Ny div for søkeforslag -->
                    </div>
                </div>
                <div class="suggestions">
                </div>
            </div>

            <div>
                <a href="handlekurv.php"><img class="img-icon" src="images/icon-img/handlekurv.png"
                        alt="profile icon"></a>
                <a href="log_inn.php"><img class="img-icon" src="images/icon-img/profile_icon.png"
                        alt="profile icon"></a>
            </div>
        </div>
    </header>

    <div class="kategori_overskrift">
        <h1>Oppskrifter</h1>
    </div>


    <div class="center">
        <div class="oppskrift_kategorier">
            <div class="space_between">
                <?php
                require_once "includes/dbh.inc.php";

                $kategoriQuery = "SELECT * FROM kategori";
                $stmt = $pdo->prepare($kategoriQuery);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($result)) {
                    echo "<p>Fant ikke noen kategorier</p>";
                    return;
                }

                foreach ($result as $kategori) {
                    $kategori_id = $kategori['id'];
                    $kategori_navn = $kategori['navn'];
                    echo "<div id='kategori_id' class='matkategori'>$kategori_navn</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="center">
        <div class="product-container">

            <?php

            require_once "includes/dbh.inc.php";

            $bildeQuery = "SELECT oppskrifter.id, oppskrifter.bilde_url, oppskrifter.tittel, oppskrifter.vansklighetgrad, oppskrifter.beregnet_tid FROM oppskrifter INNER JOIN kategori ON oppskrifter.kategori_id = kategori.id";
            $stmt = $pdo->prepare($bildeQuery);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($result)) {
                echo "<p>Fant ikke noen bilder</p>";
            } else {
                foreach ($result as $oppskrift) {
                    $bilde_url = $oppskrift['bilde_url'];
                    $bilde_tittel = $oppskrift['tittel'];
                    $vansklighetgrad = $oppskrift['vansklighetgrad'];
                    $beregnet_tid = $oppskrift['beregnet_tid'];
                    $id = $oppskrift['id'];

                    echo "<div class='recipie'>";
                    echo "<div class='center'>";
                    echo "<div class='img-box'>";
                    echo "<div class='bilde_tittel'>$bilde_tittel</div>";
                    // Sjekk at id-variabelen inkluderes riktig i lenken
                    echo "<a href='oppskrift_side.php?id=$id'><img class='maxwidth' src='images/food_images/$bilde_url' alt='$bilde_tittel'></a>\n";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='rating'></div>";
                    echo "<div class='price'>$beregnet_tid</div>";
                    echo "<div class='price'>$vansklighetgrad</div>";
                    //ny linje
                    // Sjekk at id-variabelen inkluderes riktig i lenken
                    echo "<a href='oppskrift_side.php?id=$id' class='button'>Se oppskrift</a>";
                    echo "</div>";
                }

            }

            ?>

        </div>
    </div>

    <script src="js/script.js"></script>

</body>

</html>