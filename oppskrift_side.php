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
            <div class="search_and_suggestions">
                <div class="søke_input">
                    <div class="space_between">
                        <input class="input_text" type="text" id="searchInput" placeholder="Søk etter oppskrift">
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
                    session_start();
                    require_once "includes/dbh.inc.php";
                    require_once "includes/common.php";
                    echo show_userinfo($_SESSION['bruker_id']);
                    ?>

                </div>
            </div>

        </div>
    </header>

    <div class="space_between">
        <?php

        require "includes/dbh.inc.php";
        $bruker_id = $_SESSION['bruker_id'];

        // sjekk om id er sendt med i urlen
        if ($_GET['id']) {
            // henter id fra url 
            $id = $_GET['id'];
            //sql queyen henter sumen av rating for oppskrift + hvor mange det er
            $averageQuery = "SELECT SUM(rating) AS sum, COUNT(rating) AS count FROM rating WHERE oppskrift_id = :id";
            $stmt = $pdo->prepare($averageQuery);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $firstrow = $result[0];

            //regner ut gjennomsnittet av ratingene som er lagt in på oppskriften 
            $sum = $firstrow['sum'];
            $count = $firstrow['count'];
            if ($count == 0) {
                $average = "Ingen annmeldelser";
            } else {
                $average = round($sum / $count, 1);
            }


            // henter data for oppskriften 
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
                    //definerer forskjellig informasjon om oppskriften 
                    $bilde_url = $oppskrift['bilde_url'];
                    $bilde_tittel = $oppskrift['tittel'];
                    $vanskelighetsgrad = $oppskrift['vanskelighetsgrad'];
                    $beregnet_tid = $oppskrift['beregnet_tid'];
                    $oppskrift_id = $oppskrift['id'];
                    $fremgangsmåte = $oppskrift['fremgangsmåte'];

                    // skriver ut bilde og innhold om oppskriften på siden
                    echo "<div class='oppskrift'>";
                    echo "    <img class='maxwidth' src='images/food_images/$bilde_url' alt='mat bilde'>\n";
                    echo "</div>";
                    echo "<div class='oppskrift'>";
                    echo "<div class='space_between'>\n";
                    echo "<div class='ingredienser'>";

                    require_once "includes/common.php";
                    $userinfo = getbrukerinfo($_SESSION['bruker_id']);
                    if ($userinfo["rolle"] == "kokk" || $userinfo["rolle"] == "admin") {
                        echo "<a href='endre_oppskrift.php?id=$oppskrift_id' class='button'>Endre oppskrift</a>";
                    }
                    echo "<h3>Ingredienser:<h3>";
                    //kjører functionen som skriver ut ingrediensene 
                    echo "<div class='oppskrift_info'>" . visingredienser($oppskrift_id) . "</div>";
                    // todo bare la kokker legge til på egne oppskrifter 
                    if ($userinfo["rolle"] == "kokk" || $userinfo["rolle"] == "admin") {
                        echo "<form action='endre_ingrediens_handler.php' method='POST'>";
                        echo "<input type='hidden' name='oppskrift_id' value='$oppskrift_id'>";
                        echo "<input type='hidden' name='handling' value='legg_til'>";
                        echo "<input class='input_text' class='ingrediens_input' type='text' name='mengde' placeholder='mengde'>";
                        echo "<input class='input_text' class='ingrediens_input' type='text' name='enhet' placeholder='enhet' requierd>";
                        echo "<input class='input_text' class='ingrediens_input' type='text' name='ingrediens' placeholder='ingrediens'>";
                        echo "<input class='input_submit' type='submit' value='Legg til' class='button'>";
                        echo "</form>";
                    }
                    echo "<h3>Fremgangsmåte:<h3>";
                    echo "<div class='oppskrift_info'>$fremgangsmåte</div>";
                    echo "</div>\n";
                    echo "<div class='om'>";
                    echo "<div class='bilde_tittel'>$bilde_tittel</div>";
                    echo "<div class='oppskrift_info'>Nivå: $vanskelighetsgrad</div>\n";
                    echo "<div class='oppskrift_info'>Tid: $beregnet_tid</div>";
                    echo "<div class='oppskrift_info'>Rating:$average</div>\n";
                    echo "</div>";
                    echo "</div>";
                    echo "<div>\n";
                    echo "<a href='legg_i_handlekurv.php?id=$id' class='button'>Legg til oppskrift i handlekurv</a>";
                    echo "</div>\n";
                    echo "trykk på stjernene for å gi rating <br>";

                    // henter ratingen til brukeren som er logget in 
                    $ratingQuery = "SELECT rating FROM rating WHERE bruker_id = :bruker_id AND oppskrift_id = :id";
                    $stmt = $pdo->prepare($ratingQuery);
                    $stmt->bindParam(':bruker_id', $bruker_id);
                    $stmt->bindParam(':id', $id);
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (empty($result)) {
                        $stars = 0;
                    } else {
                        $firstrow = $result[0];
                        $stars = $firstrow["rating"];
                    }

                    // skriver ut ratingen med stjerner og tallet til brukeren
                    echo "<div class='rating-box'>";
                    echo "<div class='rating-container'>";
                    echo "<div class='rating-stars'>";
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i > $stars) {
                            $bilde = "off_star.png";
                        } else {
                            $bilde = "star.png";
                        }
                        echo "<a href='legg_til_vurdering.php?oppskrift_id=$id&bruker_id=$bruker_id&rating=$i'><img width='40px' src='images/$bilde' alt='*'></a>";
                    }
                    echo "</div>";
                    echo "<div class='rating-number'>$stars</div>";
                    echo "</div>";
                    echo "</div>";

                }
            }
        } else {
            // hvis id ikke er sendt med i url gi en feilmelding
            echo "<p>Mangler oppskrifts-ID i URLen</p>";
        }

        // function som henter ingrediensene i databasen
        function visingredienser($oppskrift_id)
        {
            require "includes/dbh.inc.php";

            $resultat = "";

            // queryen henter ingrediensene i databasen 
            $ingrediensQuery = "SELECT * FROM ingrediens_mengde INNER JOIN ingredienser ON ingrediens_mengde.ingrediens_id = ingredienser.id where ingrediens_mengde.oppskrift_id = :ingid";
            $stmt = $pdo->prepare($ingrediensQuery);
            $stmt->bindParam(':ingid', $oppskrift_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // sjekker om resultatet er tomt eller ikke
            if (empty($result)) {
                return "<p>Fant ingen ingredienser for id: $oppskrift_id</p>";
            } else {
                // loop gjennom resultatene (selv om det bare er en, siden id er unik)
                foreach ($result as $ingrediens) {
                    $mengde = $ingrediens['mengde'];
                    $enhet = $ingrediens['enhet'];
                    $ingrediensnavn = $ingrediens['ingrediens'];
                    $resultat .= "$mengde $enhet $ingrediensnavn<br>\n";
                }
            }
            return $resultat;
        }
        ?>


    </div>

    <script src="js/script.js"></script>
</body>

</html>