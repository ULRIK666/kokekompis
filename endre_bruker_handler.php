<?php
session_start();
require_once "includes/common.php";
if (isset($_SESSION['bruker_id'])) {
    $userinfo = getbrukerinfo($_SESSION['bruker_id']);
    if ($userinfo != null) {
        if ($userinfo["rolle"] != "admin") {
            echo "har ikke lov til å endre bruker siden du ikke er admin bruker";
            exit();
        }
    } else {
        echo "Fant ingen bruker med denne id-en";
        exit();
    }
} else {
    echo "Fant ikke bruker_id";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $handling = $_POST['handling'];

    if (isset($_POST['bruker_id'])) {
        $bruker_id = $_POST['bruker_id'];

        try {
            // Koble til databasen
            require "includes/dbh.inc.php";
            echo $handling;
            if ($handling == "endre") {
                if (isset($_POST['rolle'])) {
                    $ny_rolle = $_POST['rolle'];
                    $sql = "UPDATE brukere SET rolle_id = :rolle WHERE id = :bruker_id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(":rolle", $ny_rolle);
                    $stmt->bindParam(":bruker_id", $bruker_id);
                }
            } elseif ($handling == "slett") {
                $slettet_tid = date("Y-m-d H:i:s");

                $sql = "UPDATE brukere SET slettet_tid = :slettet_tid WHERE id = :bruker_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":bruker_id", $bruker_id);
                $stmt->bindParam(":slettet_tid", $slettet_tid);
            }

            $stmt->execute();

            header("Location: brukerliste.php");

            exit();
        } catch (PDOException $e) {
            header("Location: brukerliste.php?error=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        header("Location: brukerliste.php?error=missing_data");
        exit();
    }

} else {
    header("Location: brukerliste.php?error=invalid_method");
    exit();
}
?>