<?php
require_once "includes/dbh.inc.php";

// henter søket som er skrevet in 
if (isset($_GET['q'])) {
    $searchText = $_GET['q'];

    // queryen henter oppskrifter som har tittel som inneholder søket som er skrevet inn 
    $searchQuery = "SELECT * FROM oppskrifter WHERE tittel LIKE ?";
    $stmt = $pdo->prepare($searchQuery);
    $stmt->execute(["%$searchText%"]); // bruker søketeksten direkte
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    if (empty($result)) {
        echo "<div class='search-suggestion-item'>Ingen forslag funnet</div>";
    } else {
        foreach ($result as $oppskrift) {
            $bilde_url = $oppskrift['bilde_url'];
            $bilde_tittel = $oppskrift['tittel'];
            $vanskelighetsgrad = $oppskrift['vanskelighetsgrad'];
            $beregnet_tid = $oppskrift['beregnet_tid'];
            $id = $oppskrift['id'];

            // skriver ut det som skal komme ut under søke feltet 
            echo "<a href='oppskrift_side.php?id=$id' class='search-suggestion-item'>";
            echo "<img class='suggestion_img_maxwidth' src='images/food_images/$bilde_url' alt='$bilde_tittel'>";
            echo $bilde_tittel; // Viser søkeforslagene"
            echo "<div>";
            echo "<div class='price' class='nolink'>$beregnet_tid</div>";
            echo "<div class='price' class='nolink'>$vanskelighetsgrad</div>";
            echo "</div>";
            echo "</a>";


        }

    }
}
?>