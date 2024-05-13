<?php
require "includes/dbh.inc.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $handling = $_POST['handling'];

    if (isset($_SESSION['bruker_id'])) {
        $bruker_id = $_SESSION['bruker_id'];

        try {
            // Koble til databasen
            if ($handling == "legg_til") {
                if (isset($_POST['oppskrift_id'])) {
                    $oppskrift_id = $_POST['oppskrift_id'];
                } else {
                    echo "må ha en oppskrift_id";
                    exit();
                }
                if (isset($_POST['mengde'])) 
                    $mengde = $_POST['mengde'];
                //todo fiks null ting 
                else 
                    $mengde = null;
                if (isset($_POST['enhet']))
                    $enhet = $_POST['enhet'];
                if (isset($_POST['ingrediens'])) {
                    $ingrediens = $_POST['ingrediens'];
                } else {
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
            }
        } catch (PDOException $e) {
            echo "feilmelding:" . $e->getMessage();
            exit();
        }
    } else {
        echo "feilmelding:=missing_data";
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