<?php
require "includes/dbh.inc.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['handling']))
        $handling = $_POST['handling'];
    if (isset($_POST['oppskrift_id']))
        $oppskrift_id = $_POST['oppskrift_id'];
    if (isset($_POST['mengde']))
        $mengde = $_POST['mengde'];
    if (isset($_POST['ingrediens']))
        $ingrediens = $_POST['ingrediens'];
    if (isset($_POST['enhet']))
        $enhet = $_POST['enhet'];

} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['handling']))
        $handling = $_GET['handling'];
    if (isset($_GET['id']))
        $id = $_GET['id'];
    if (isset($_GET['oppskrift_id']))
        $oppskrift_id = $_GET['oppskrift_id'];
}

if (isset($_SESSION['bruker_id'])) {
    $bruker_id = $_SESSION['bruker_id'];
    try {
        // Koble til databasen
        if ($handling == "legg_til") {
            if (!isset($oppskrift_id)) {
                echo "må ha en oppskrift_id";
                exit();
            }
            if (!isset($mengde))
                $mengde = null;
            if (!isset($enhet))
                $enhet = null;
            if (!isset($ingrediens)) {
                echo "må ha en ingrediens for å legge til";
                exit();
            }
            $ingrediens_id = opprett_eller_finn_ingrediens($ingrediens);
            //                $enhet_id = opprett_eller_finn_enhet($enhet);
            $sql = "INSERT INTO ingrediens_mengde (oppskrift_id, mengde, enhet, ingrediens_id) VALUES (:oppskrift_id, :mengde, :enhet, :ingrediens_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":oppskrift_id", $oppskrift_id);
            $stmt->bindParam(":mengde", $mengde);
            $stmt->bindParam(":enhet", $enhet);
            $stmt->bindParam(":ingrediens_id", $ingrediens_id);
            $stmt->execute();

            header("Location: oppskrift_side.php?id=$oppskrift_id");

            exit();
        } elseif ($handling == "slett") {
            if (!isset($id)) {
                echo "må ha en id for å slette ingrediens";
                exit();
            }

            $sql = "DELETE FROM ingrediens_mengde WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            header("Location: oppskrift_side.php?id=$oppskrift_id");

        }
    } catch (PDOException $e) {
        echo "feilmelding:" . $e->getMessage();
        exit();
    }

} else {
    echo "feilmedling:invalid_method";
    exit();
}


function opprett_eller_finn_ingrediens($ingrediens_navn)
{
    require "includes/dbh.inc.php";

    $sql = "SELECT * FROM ingredienser WHERE ingrediens = :ingrediens_navn";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":ingrediens_navn", $ingrediens_navn);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        return ($result['id']);
    } else {
        $sql = "INSERT INTO ingredienser (ingrediens) values (:ingrediens_navn) ";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":ingrediens_navn", $ingrediens_navn);
        $stmt->execute();

        $last_id = $pdo->lastInsertId();
        return ($last_id);
    }
}
?>