<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // henter infylt brukernavn og passord
    $brukernavn = $_POST["brukernavn"];
    $passord = $_POST["passord"];
    $epost = $_POST["epost"];
    $telefon = $_POST["telefon"];
    $adresse = $_POST["adresse"];
    $postnummer = $_POST["postnummer"];
    $poststed = $_POST["poststed"];

    
    try {
        require_once "dbh.inc.php";

        // skriver in brukernavn og passord in i databasen 
        $query = "INSERT INTO brukere (brukernavn, passord, epost, telefon, adresse, postnummer, poststed) 
                  VALUES (:brukernavn, :passord, :epost , :telefon, :adresse, :postnummer, :poststed);";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":brukernavn", $brukernavn);
        $stmt->bindParam(":passord", $passord);
        $stmt->bindParam(":epost", $epost);
        $stmt->bindParam(":telefon", $telefon);
        $stmt->bindParam(":adresse", $adresse);
        $stmt->bindParam(":postnummer", $postnummer);
        $stmt->bindParam(":poststed", $poststed);

        $stmt->execute();

        //$pdo = null;
        $stmt = null;

        // sender deg tilbake osv
        header("location: ../index.php");

        die();
    } catch (PDOException $e) {
        die("Query failed:". $e->getMessage());
    }
} else {
    header("location: ../index.php");
}