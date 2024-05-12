<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // henter brukernavn og passord med post 
    $brukernavn = $_POST["brukernavn"];
    $passord = $_POST["passord"];

    try {
        require_once "dbh.inc.php";

        // henter nødvendig informasjon fra bruker så man kan logge inn
        $query = "SELECT brukere.id, brukere.passord, roller.rolle 
                  FROM brukere 
                  INNER JOIN roller ON brukere.rolle_id = roller.id 
                  WHERE brukere.brukernavn = :brukernavn";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":brukernavn", $brukernavn);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // sender feilmelding med session hvis den ikke gir ut noe 
        if (empty($result)) {
            $_SESSION['error_message'] = "Ukjent brukernavn eller passord!";
            header("location: ../log_inn.php");
            exit();
        } else {
            //definerer infoen den hentet fra bolle og brukere tabellene 
            $bruker_id = $result["id"];
            $signup_pwd = $result["passord"];
            $rolle = $result["rolle"];
        }

        // sjekker om det er riktig passord
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
        // sender deg tilbake med en feilmelding i session 
        $_SESSION['error_message'] = "Query failed: " . $e->getMessage();
        header("location: ../log_inn.php");
        exit();
    }
} else {
    header("location: ../log_inn.php");
    exit();
}
?>