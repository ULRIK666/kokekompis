<?php


function getbrukerinfo($id)
{
    try {
        require "dbh.inc.php";
        // Forbered og utfør spørringen
        $query = "SELECT brukere.brukernavn, brukere.navn, roller.rolle 
              FROM brukere 
              INNER JOIN roller ON brukere.rolle_id = roller.id 
              WHERE brukere.id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            return (null);
            //$_SESSION['error_message'] = "Ukjent brukernavn eller passord!";
            //header("location: ../log_inn.php");
            //exit();
        } else {
            $brukerinfo = array("brukernavn" => $result["brukernavn"], 
            "rolle" => $result["rolle"],
            "navn" => $result["navn"]);
            return ($brukerinfo);
        }
    } catch (PDOException $e) {
        return (null);
    }
}
?>