<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // henter det som er fylt ut i formen 
    $navn = $_POST["navn"];
    $brukernavn = $_POST["brukernavn"];
    $passord = $_POST["passord"];
    $epost = $_POST["epost"];
    $telefon = $_POST["telefon"];
    $adresse = $_POST["adresse"];
    $postnummer = $_POST["postnummer"];
    $poststed = $_POST["poststed"];

    
    try {
        require_once "dbh.inc.php";

        // skriver in info om den nye brukeren i tabellen brukere 
        $query = "INSERT INTO brukere (navn, brukernavn, passord, epost, telefon, adresse, postnummer, poststed, rolle_id) 
                  VALUES (:navn, :brukernavn, :passord, :epost , :telefon, :adresse, :postnummer, :poststed, 1);"; // setter rolle id til 1 som er kunde 

        $stmt = $pdo->prepare($query);

        // bindparam for inserten 
        $stmt->bindParam(":navn", $navn);
        $stmt->bindParam(":brukernavn", $brukernavn);
        $stmt->bindParam(":passord", $passord);
        $stmt->bindParam(":epost", $epost);
        $stmt->bindParam(":telefon", $telefon);
        $stmt->bindParam(":adresse", $adresse);
        $stmt->bindParam(":postnummer", $postnummer);
        $stmt->bindParam(":poststed", $poststed);

        $stmt->execute();

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