<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Oppskrift side</title>
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
            <div class="søke_input">
                <div class="space_between">
                    <img class="img-icon" src="images/icon-img/search_icon.png" alt="søke ikon">
                    <input type="text" id="searchInput" placeholder="Søk etter oppskrift">
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


    <div class="space_between">
        <?php
        require_once "includes/dbh.inc.php";

        // Sjekk om id er sendt med i URLen
        if (isset($_GET['id'])) {
            // Hent id fra URLen og beskytt mot SQL-injeksjon
            $id = intval($_GET['id']);

            // Forbered og utfør spørringen med parameteren
            $oppskriftQuery = "SELECT * FROM oppskrifter WHERE id = :id";
            $stmt = $pdo->prepare($oppskriftQuery);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Sjekk om resultatet er tomt eller ikke
            if (empty($result)) {
                echo "<p>Fant ikke oppskriften</p>";
            } else {
                // Loop gjennom resultatene (selv om det bare er én, siden id er unik)
                foreach ($result as $oppskrift) {
                    $bilde_url = $oppskrift['bilde_url'];
                    $bilde_tittel = $oppskrift['tittel'];
                    $vansklighetgrad = $oppskrift['vansklighetgrad'];
                    $beregnet_tid = $oppskrift['beregnet_tid'];
                    $id = $oppskrift['id'];

                    // Utskrift av oppskriftdetaljer
                    echo "<div class='oppskrift'>";
                    echo "    <img class='maxwidth' src='images/food_images/$bilde_url' alt='mat bilde'>";
                    echo "</div>";
                    echo "<div class='oppskrift'>";
                    echo "<div class='space_between'>";
                    echo "<div class='ingridienser'>";
                    echo "<h3>ingridienser:<h3>";
                    echo "</div>";
                    echo "<div class='om'>";
                    echo "<div class='bilde_tittel'>$bilde_tittel</div>";
                    echo "<div class='rating'></div>";
                    echo "<div class='price'>$beregnet_tid</div>";
                    echo "<div class='price'>$vansklighetgrad</div>";
                    echo "</div>";
                    //ny linje
                    echo "</div>";
                }
            }
        } else {
            // Hvis id ikke er sendt med i URLen, gi en feilmelding
            echo "<p>Mangler oppskrifts-ID i URLen</p>";
        }
        ?>


    </div>

</body>

</html>