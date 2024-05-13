<?php
        if ($_GET['id']) {
            $id = $_GET['id'];

    try {
        require_once "includes/dbh.inc.php";

    $deleteQuery = "DELETE FROM oppskrifter WHERE id = :id";
    $stmt = $pdo->prepare($deleteQuery);

    $stmt->bindParam(":id", $id);


    $stmt->execute();

    header("location: index.php");

    exit();
} catch (PDOException $e) {
    die("Query failed:" . $e->getMessage());
}
} else {
echo "ingen get";
}
?>