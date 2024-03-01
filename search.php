<?php
require_once "includes/dbh.inc.php";

if (isset($_GET['q'])) {
    $searchText = $_GET['q'];


    $searchQuery = "SELECT * FROM oppskrifter WHERE tittel LIKE ?";
    $stmt = $pdo->prepare($searchQuery);
    $stmt->execute(["%$searchText%"]); // Endret her for å bruke søketeksten direkte
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($result)) {
        echo "<div class='search-suggestion-item'>Ingen forslag funnet</div>";
    } else {
        foreach ($result as $oppskrift) {
            $bilde_url = $oppskrift['bilde_url'];
            $bilde_tittel = $oppskrift['tittel'];
            $vansklighetgrad = $oppskrift['vansklighetgrad'];
            $beregnet_tid = $oppskrift['beregnet_tid'];
            $id = $oppskrift['id'];

            echo "<a href='oppskrift_side.php?id=$id' class='search-suggestion-item'>";
            echo "<img class='suggestion_img_maxwidth' src='images/food_images/$bilde_url' alt='$bilde_tittel'>";
            echo $bilde_tittel; // Viser søkeforslagene"
            echo "<div>";
            echo "<div class='price' class='nolink'>$beregnet_tid</div>";
            echo "<div class='price' class='nolink'>$vansklighetgrad</div>";
            echo "</div>";
            echo "</a>";


        }

    }
/*
    // SQL-spørring for å hente søkeforslag basert på det brukeren har skrevet inn
    $searchQuery = "SELECT tittel FROM oppskrifter WHERE tittel LIKE ? LIMIT 5";
    $stmt = $pdo->prepare($searchQuery);
    $stmt->execute(["%$searchText%"]);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
*/

}
?>
