<?php
require_once "includes/dbh.inc.php";

// Sjekk om oppskrifts-ID er sendt via URL-parameteren
if (isset($_GET['id'])) {
    $oppskrift_id = $_GET['id'];

    // Sjekk om vurderingen er sendt via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["rating"])) {
        $vurdering = $_POST["rating"];

        // Hent brukerens ID fra sessionsvariabelen
        $bruker_id = $_SESSION['bruker_id'];

        // Sett inn vurderingen i databasen sammen med brukerens ID og oppskrifts-ID
        $query = "INSERT INTO rating (oppskrift_id, bruker_id, vurdering) VALUES (:oppskrift_id, :bruker_id, :vurdering)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":oppskrift_id", $oppskrift_id);
        $stmt->bindParam(":vurdering", $vurdering);
        $stmt->bindParam(":bruker_id", $bruker_id);

        // Utfør spørringen og sjekk om det var noen feil
        if ($stmt->execute()) {
            echo "Vurderingen ble lagt til i databasen.";
        } else {
            echo "Det oppstod en feil ved å legge til vurderingen i databasen.";
            echo "Feilmelding: " . $stmt->errorInfo()[2];
        }

        // Omdiriger brukeren tilbake til oppskriftssiden etter å ha lagt til vurderingen
        //header("Location: oppskrift_side.php?id=$oppskrift_id");
        //exit;
    } else {
        echo "Vurderingen ble ikke sendt via POST-metoden.";
    }
} else {
    echo "Oppskrifts-ID ble ikke sendt via URL-parameteren.";
}
?>
