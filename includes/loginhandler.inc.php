<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Hente brukernavn og passord
    $brukernavn = $_POST["brukernavn"];
    $passord = $_POST["passord"];

    try {
        require_once "dbh.inc.php";

        // Forbered og utfør spørringen
        $query = "SELECT brukere.id, brukere.passord, roller.rolle 
                  FROM brukere 
                  INNER JOIN roller ON brukere.rolle_id = roller.id 
                  WHERE brukere.brukernavn = :brukernavn";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":brukernavn", $brukernavn);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $_SESSION['error_message'] = "Ukjent brukernavn eller passord!";
            header("location: ../log_inn.php");
            exit();
        } else {
            $bruker_id = $result["id"];
            $signup_pwd = $result["passord"];
            $rolle = $result["rolle"];
        }

        // Sjekk passord
        if ($passord == $signup_pwd) {
            $_SESSION['bruker_id'] = $bruker_id;
            header("location: ../index.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Feil passord";
            header("location: ../log_inn.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Query failed: " . $e->getMessage();
        header("location: ../log_inn.php");
        exit();
    }
} else {
    header("location: ../log_inn.php");
    exit();
}
?>
