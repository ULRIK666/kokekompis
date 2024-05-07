<?php
    require_once "includes/dbh.inc.php";

session_start();

// Sjekk om brukeren er logget inn
if (!isset($_SESSION['bruker_id']) || $_SESSION['bruker_id'] == 0) {
    echo "Du må være logget inn for å legge til oppskrifter i handlekurven.";
    exit; // Avslutt skriptet hvis brukeren ikke er logget inn
}


if ($_GET['id']) {
    // Hent id fra URLen og beskytt mot SQL-injeksjon
    $id = $_GET['id'];
    echo $id;
    // Forbered og utfør spørringen med parameteren

    try {
        // Hent oppskriftens pris
// Hent oppskriftens pris
        $query = "SELECT pris FROM oppskrifter WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);        

        if (!$result) {
            echo "Fant ikke oppskrift med ID $id.";
            echo $id;

            exit;
        }

        $pris = $result['pris'];

        // Legg til oppskriften i handlekurven
        $query = "INSERT INTO handlekurv (kunde_id, oppskrift_id, pris, antall) VALUES (:kunde_id, :oppskrift_id, :pris, 1)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":kunde_id", $_SESSION['id']);
        $stmt->bindParam(":oppskrift_id", $id);
        $stmt->bindParam(":pris", $pris);
        $stmt->execute();

        header("Location: index.php");
        exit;
    } catch (PDOException $e) {
        echo "Feil: " . $e->getMessage();
    }
} else {
    echo "Feil forespørsel.";
}
?>
<!-- function fetchId($id){
       $query = "SELECT pris FROM oppskrifter WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return implode($result)

        return $result;
} 

if(!fetchId($id)){
    echo "Fant ikke oppskrift med ID $id.";
            echo $id;

            exit;
        } else{
            //do whatever the hell you want to do with the ID
        }
    -->