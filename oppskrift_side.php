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

    <div class="space_between">
        <?php
        session_start();

        require "includes/dbh.inc.php";
        $bruker_id = $_SESSION['bruker_id']; 

        // Sjekk om id er sendt med i URLen
        if ($_GET['id']) {
            // Hent id fra URLen og beskytt mot SQL-injeksjon
            $id = $_GET['id'];
            $averageQuery = "SELECT SUM(rating) AS sum, COUNT(rating) AS count FROM rating WHERE oppskrift_id = :id";
            $stmt = $pdo->prepare($averageQuery);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $firstrow = $result[0];

            $sum = $firstrow['sum'];
            $count = $firstrow['count'];
            if ($count == 0) {
                $average = "Ingen annmeldelser";
            } else {
                $average = round($sum / $count, 1);
            }


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
                    $oppskrift_id = $oppskrift['id'];
                    $fremgangsmåte = $oppskrift['fremgangsmåte'];

                    

                        
                    // Utskrift av oppskriftdetaljer
                    echo "<div class='oppskrift'>";
                    echo "    <img class='maxwidth' src='images/food_images/$bilde_url' alt='mat bilde'>\n";
                    echo "</div>";
                    echo "<div class='oppskrift'>";
                    echo "<div class='space_between'>\n";
                    echo "<div class='ingredienser'>";
                    echo "<h3>Ingredienser:<h3>";
                    echo visingredienser($oppskrift_id);
                    echo "<h3>Fremgangsmåte:<h3>";
                    echo $fremgangsmåte;
                    echo "</div>\n";
                    echo "<div class='om'>";
                    echo "<div class='bilde_tittel'>$bilde_tittel</div>";
                    echo "<div class='oppskrift_info'>Nivå: $vansklighetgrad</div>\n";
                    echo "<div class='oppskrift_info'>Tid: $beregnet_tid</div>";
                    echo "<div class='oppskrift_info'>Rating:$average</div>\n";

                    echo "</div>";
                    //ny linje

                    echo "</div>";
                    echo "<div>\n";
                    echo "<a href='legg_i_handlekurv.php?id=<?= $id ?>' class='button'>Legg til oppskrift i handlekurv</a>


                    ";
                    echo "</div>\n";
                    echo "trykk på stjernene for å gi rating <br>";

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

                    for ($i=1; $i <= 5; $i++) {
                        if ($i > $stars) {
                            $bilde = "off_star.png";
                        } else {
                            $bilde = "star.png";
                        }
                        echo "<a href='legg_til_vurdering.php?oppskrift_id=$id&bruker_id=$bruker_id&rating=$i'><img width='40px' src='images/$bilde' alt='*'></a>";
                    }
                    echo "$stars";


                    echo "<div class='rating-container'>";
                    echo "<a href='legg_til_vurdering.php?oppskrift_id=<?= $id ?>' class='button'>Legg til vurdering</a>";

                    echo "<div class='rating-stars'>
                    <input type='radio' name='rating' id='rs0' checked><label for='rs0'></label>
                    <input type='radio' name='rating' id='rs1'><label for='rs1'></label>
                    <input type='radio' name='rating' id='rs2'><label for='rs2'></label>
                    <input type='radio' name='rating' id='rs3'><label for='rs3'></label>
                    <input type='radio' name='rating' id='rs4'><label for='rs4'></label>
                    <input type='radio' name='rating' id='rs5'><label for='rs5'></label>
                    <span class='rating-counter'></span>
                </div>";
                echo "</div>";
                }
            }
        } else {
            // Hvis id ikke er sendt med i URLen, gi en feilmelding
            echo "<p>Mangler oppskrifts-ID i URLen</p>";
        }

        function visingredienser($oppskrift_id) {
            require "includes/dbh.inc.php";

            $resultat = "";

             // Forbered og utfør spørringen med parameteren
             $ingrediensQuery = "SELECT * FROM ingrediens_mengde INNER JOIN ingredienser ON ingrediens_mengde.ingrediens_id = ingredienser.id where ingrediens_mengde.oppskrift_id = :ingid";
             $stmt = $pdo->prepare($ingrediensQuery);
             $stmt->bindParam(':ingid', $oppskrift_id, PDO::PARAM_INT);
             $stmt->execute();
             $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
             // Sjekk om resultatet er tomt eller ikke
             if (empty($result)) {
                 return "<p>Fant ingen ingredienser for id: $oppskrift_id</p>";
             } else {
                 // Loop gjennom resultatene (selv om det bare er én, siden id er unik)
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

</body>

</html>