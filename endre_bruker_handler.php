<?php
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

                $sql = "DELETE FROM brukere WHERE id = :bruker_id";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(":bruker_id", $bruker_id);
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