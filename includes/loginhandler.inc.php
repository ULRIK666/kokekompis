<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //hente brukernavn og passord
    $brukernavn = $_POST["brukernavn"];
    $passord = $_POST["passord"];

    try {
        require_once "dbh.inc.php";


        # 1 - finner bruker

        $query = "select id, passord from brukere where brukernavn = :brukernavn";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":brukernavn", $brukernavn);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if (empty($result)) {
            echo "<p>Ukjent brukernavn!</p>";
            return;
        } else {
            $row = $result[0];
            $signup_pwd = $row["passord"];
            $bruker_id = $row["id"];
        }

        # 2 - sjekker passord
        session_start();
        if ($passord == $signup_pwd) {
            $_SESSION['bruker_id'] = $bruker_id;
        } else {
            $_SESSION['id'] = 0;  // 0 betyr ikke logget inn
            echo "<p>Feil passord</p>";
            return;
        }

        $pdo = null;
        $stmt = null;

        header("location: ../index.php");

        die();
    } catch (PDOException $e) {
        die("Query failed:" . $e->getMessage());
    }
} else {
    header("location: ../log_inn.php");
}