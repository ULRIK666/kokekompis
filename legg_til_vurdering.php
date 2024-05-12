<?php
require_once "includes/dbh.inc.php";
session_start();
$bruker_id = $_SESSION['bruker_id'];

if (!isset($bruker_id)) {
    echo "du må være logget inn for å gi en rating";
    exit();
}



// Sjekk om oppskrifts-ID er sendt via URL-parameteren
if (isset($_GET['oppskrift_id'])) {
    $oppskrift_id = $_GET['oppskrift_id'];

    // Sjekk om vurderingen er sendt via POST
    $rating = $_GET["rating"];
    // Hent brukerens ID fra sessionsvariabelen

    try {
        $query = "DELETE FROM rating WHERE bruker_id = :bruker_id AND oppskrift_id = :oppskrift_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":oppskrift_id", $oppskrift_id);
        $stmt->bindParam(":bruker_id", $bruker_id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "trengte ikke slette noe før inserten";
    }

    // Sett inn vurderingen i databasen sammen med brukerens ID og oppskrifts-ID
    $query = "INSERT INTO rating (oppskrift_id, bruker_id, rating) VALUES (:oppskrift_id, :bruker_id, :rating)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":oppskrift_id", $oppskrift_id);
    $stmt->bindParam(":rating", $rating);
    $stmt->bindParam(":bruker_id", $bruker_id);

    // Utfør spørringen og sjekk om det var noen feil
    if ($stmt->execute()) {
        header("location: oppskrift_side.php?id=$oppskrift_id");
        } else {
        echo "Det oppstod en feil ved å legge til vurderingen i databasen.";
        echo "Feilmelding: " . $stmt->errorInfo()[2];
    }

    // Omdiriger brukeren tilbake til oppskriftssiden etter å ha lagt til vurderingen
    //header("Location: oppskrift_side.php?id=$oppskrift_id");
    //exit;
} else {
    echo "Oppskrifts-ID ble ikke sendt via URL-parameteren.";
}
?>