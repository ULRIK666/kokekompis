<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //hente brukernavn og passord
    $brukernavn = $_POST["brukernavn"];
    $passord = $_POST["passord"];

    try {
        require_once "dbh.inc.php";


        # 1 - finner bruker

        $query = "SELECT id, passord FROM brukere WHERE brukernavn = :brukernavn";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":brukernavn", $brukernavn);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if (empty($result)) {
            $_SESSION['error_message'] = "Ukjent brukernavn eller passord!";
            header("location: ../log_inn.php");
            exit();
        } else {
            $row = $result[0];
            $signup_pwd = $row["passord"];
            $bruker_id = $row["id"];
        }

        # 2 - sjekker passord

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
