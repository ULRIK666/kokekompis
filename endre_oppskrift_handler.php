<?php
session_start();
require_once "includes/common.php";
if (isset($_SESSION['bruker_id'])) {
    $userinfo = getbrukerinfo($_SESSION['bruker_id']);
    if ($userinfo != null) {
        if ($userinfo["rolle"] != "admin" && $userinfo["rolle"] != "kokk") {
            echo "har ikke lov til å endre oppskrifter siden du ikke er admin eller kokk";
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
    $id = $_POST["id"];
    $tittel = $_POST["tittel"];
    $vanskelighetsgrad = $_POST["vanskelighetsgrad"];
    $anbefalt_porsjoner = $_POST["anbefalt_porsjoner"];
    $kategori_id = $_POST["kategori_id"];
    $beregnet_tid = $_POST["beregnet_tid"];
    $pris = $_POST["pris"];
    $fremgangsmaate = $_POST["fremgangsmåte"];
    $utgitt_dato = date("Y-m-d H:i:s");

    try {
        require_once "includes/dbh.inc.php";

        $endreQuery = "UPDATE oppskrifter SET tittel = :tittel, utgitt_dato = :utgitt_dato, vanskelighetsgrad = :vanskelighetsgrad, anbefalt_porsjoner = :anbefalt_porsjoner, kategori_id = :kategori_id, beregnet_tid = :beregnet_tid, pris = :pris, fremgangsmåte = :fremgangsmaate WHERE id = :id";
        $stmt = $pdo->prepare($endreQuery);

        // bindparam for inserten 
        $stmt->bindParam(":tittel", $tittel);
        $stmt->bindParam(":utgitt_dato", $utgitt_dato);
        $stmt->bindParam(":vanskelighetsgrad", $vanskelighetsgrad);
        $stmt->bindParam(":anbefalt_porsjoner", $anbefalt_porsjoner);
        $stmt->bindParam(":kategori_id", $kategori_id);
        $stmt->bindParam(":beregnet_tid", $beregnet_tid);
        $stmt->bindParam(":pris", $pris);
        $stmt->bindParam(":fremgangsmaate", $fremgangsmaate);
        $stmt->bindParam(":id", $id);


        $stmt->execute();

        header("location: oppskrift_side.php?id=$id");

        exit();
    } catch (PDOException $e) {
        die("Query failed:" . $e->getMessage());
    }
} else {
    echo "ingen post";
}
?>