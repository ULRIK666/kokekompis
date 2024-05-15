<?php
require_once "includes/dbh.inc.php";
session_start();

if (isset($_SESSION['bruker_id'])) {
    $bruker_id = $_SESSION['bruker_id'];
}

//kjekker om man er logget in
if (!isset($bruker_id)) {
    echo "du må være logget inn for å gi en rating";
    exit();
}

// sjekker om oppskrifts-id er sendt i urlen
if (isset($_GET['oppskrift_id'])) {
    $oppskrift_id = $_GET['oppskrift_id'];

    //henter ratingen som er sendt i url
    $rating = $_GET["rating"];

    try {
        //sletter vurderingen som ligger i rating enten den er der eller ikke 
        $query = "DELETE FROM rating WHERE bruker_id = :bruker_id AND oppskrift_id = :oppskrift_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":oppskrift_id", $oppskrift_id);
        $stmt->bindParam(":bruker_id", $bruker_id);
        $stmt->execute();
    } catch (PDOException $e) {
        echo "trengte ikke slette noe før inserten";
    }

    // setter inn vurderingen i databasen
    $query = "INSERT INTO rating (oppskrift_id, bruker_id, rating) VALUES (:oppskrift_id, :bruker_id, :rating)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":oppskrift_id", $oppskrift_id);
    $stmt->bindParam(":rating", $rating);
    $stmt->bindParam(":bruker_id", $bruker_id);


    //sender deg tilbake igjen
    if ($stmt->execute()) {
        header("location: oppskrift_side.php?id=$oppskrift_id");
    } else {
        echo "Det oppstod en feil ved å legge til vurderingen i databasen.";
        echo "Feilmelding: " . $stmt->errorInfo()[2];
    }

} else {
    echo "Oppskrifts-ID ble ikke sendt via URL-parameteren.";
}
?>