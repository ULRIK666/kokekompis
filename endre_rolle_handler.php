<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['bruker_id']) && isset($_POST['rolle'])) {
        $bruker_id = $_POST['bruker_id'];
        $ny_rolle = $_POST['rolle'];

        try {
            // Koble til databasen
            require_once "includes/dbh.inc.php";

            $sql = "UPDATE brukere SET rolle_id = :rolle WHERE id = :bruker_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":rolle", $ny_rolle);
            $stmt->bindParam(":bruker_id", $bruker_id);

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
