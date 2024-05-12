<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kokekompis</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
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
                <div class="user-info">
                    <!-- forteller hvem som er logget in -->
                    <?php
                    if (isset($_SESSION['bruker_id'])) {
                        $id = $_SESSION['bruker_id'];
                        require_once "includes/dbh.inc.php";
                        require_once "includes/common.php";
                        $info = getbrukerinfo($id);

                        echo "<span>Logget inn som: <br> $info[navn] <br> som: $info[rolle]</span>";
                    } else {
                        echo "Du er ikke logget inn";
                    }
                    ?>
                </div>
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

                // henter kategorier fra databasen
                $kategoriQuery = "SELECT * FROM kategori";
                $stmt = $pdo->prepare($kategoriQuery);
                $stmt->execute();
                $kategorier = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //skjekker om det er kategorier og skriver de ut hvis det er det 
                if (empty($kategorier)) {
                    echo "<p>Fant ikke noen kategorier</p>";
                } else {
                    echo "<div class='matkategori' data-kategori-id='alle'>Alle oppskrifter</div>";
                    foreach ($kategorier as $kategori) {
                        $kategori_id = $kategori['id'];
                        $kategori_navn = $kategori['navn'];
                        echo "<div class='matkategori' data-kategori-id='$kategori_id'>$kategori_navn</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <div class="center">
        <div class="product-container">
            <?php
            // henter oppskrifter og infoen deres fra databasen
            $oppskriftQuery = "SELECT oppskrifter.id, oppskrifter.bilde_url, oppskrifter.tittel, oppskrifter.vansklighetgrad, oppskrifter.beregnet_tid, oppskrifter.kategori_id FROM oppskrifter";
            $stmt = $pdo->prepare($oppskriftQuery);
            $stmt->execute();
            $oppskrifter = $stmt->fetchAll(PDO::FETCH_ASSOC);

            //skjekker om det er oppskrifter og skriver ut resultatet med bilde osv
            if (empty($oppskrifter)) {
                echo "<p>Fant ikke noen oppskrifter</p>";
            } else {
                foreach ($oppskrifter as $oppskrift) {
                    echo "<div class='recipie' style='display:none;' data-kategori-id='" . $oppskrift['kategori_id'] . "'>";
                    echo "<div class='center'>";
                    echo "<div class='img-box'>";
                    echo "<div class='bilde_tittel'>" . $oppskrift['tittel'] . "</div>";
                    echo "<a href='oppskrift_side.php?id=" . $oppskrift['id'] . "'><img class='maxwidth' src='images/food_images/" . $oppskrift['bilde_url'] . "' alt='" . $oppskrift['tittel'] . "'></a>\n";
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='rating'></div>";
                    echo "<div class='price'>" . $oppskrift['beregnet_tid'] . "</div>";
                    echo "<div class='price'>" . $oppskrift['vansklighetgrad'] . "</div>";
                    echo "<a href='oppskrift_side.php?id=" . $oppskrift['id'] . "' class='button'>Se oppskrift</a>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>

    <script src="js/script.js"></script>

</body>

</html>