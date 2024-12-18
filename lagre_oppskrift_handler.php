<?php
session_start();
        require_once "includes/common.php";
        if (isset($_SESSION['bruker_id'])) {
            $userinfo = getbrukerinfo($_SESSION['bruker_id']);
            if ($userinfo != null) {
                if ($userinfo["rolle"] != "admin" && $userinfo["rolle"] != "kokk") {
                    echo "har ikke lov til å legge til oppskrifter siden du ikke er admin eller kokk";
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
    // henter det som er fylt ut i formen 
    $tittel = $_POST["tittel"];
    $vanskelighetsgrad = $_POST["vanskelighetsgrad"];
    $anbefalt_porsjoner = $_POST["anbefalt_porsjoner"];
    $kategori_id = $_POST["kategori_id"];
    $beregnet_tid = $_POST["beregnet_tid"];
    $pris = $_POST["pris"];
    $fremgangsmaate = $_POST["fremgangsmåte"];
    $utgitt_dato = date("Y-m-d H:i:s");
    try {
        require "includes/dbh.inc.php";
        // skriver in info om den nye brukeren i tabellen brukere 
        $query = "INSERT INTO oppskrifter (tittel, utgitt_dato, vanskelighetsgrad, anbefalt_porsjoner, kategori_id, beregnet_tid, pris, fremgangsmåte) 
                  VALUES (:tittel, :utgitt_dato, :vanskelighetsgrad , :anbefalt_porsjoner, :kategori_id, :beregnet_tid, :pris, :fremgangsmaate);"; // setter rolle id til 1 som er kunde 

        $stmt = $pdo->prepare($query);

        // bindparam for inserten 
        $stmt->bindParam(":tittel", $tittel);
        $stmt->bindParam(":utgitt_dato", $utgitt_dato);
        $stmt->bindParam(":vanskelighetsgrad", $vanskelighetsgrad);
        $stmt->bindParam(":anbefalt_porsjoner", $anbefalt_porsjoner);
        $stmt->bindParam(":kategori_id", $kategori_id);
        $stmt->bindParam(":beregnet_tid", $beregnet_tid);
        $stmt->bindParam(":pris", $pris);
        $stmt->bindParam(":fremgangsmaate", $fremgangsmaate);

        $stmt->execute();
        $last_id = $pdo->lastInsertId();


        $stmt = null;

        // sender deg tilbake osv
        //  header("location: ../.php");
        echo "alt gikk bra";
        header("location: oppskrift_side.php?id=$last_id");


        exit();
    } catch (PDOException $e) {
        die("Query failed:" . $e->getMessage());
    }
} else {
    echo "ingen post";
}