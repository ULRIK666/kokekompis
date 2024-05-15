<?php
// denne siden henter brukerinfo, siden det er felere sider som trenger bruker info

function getbrukerinfo($id)
{
    try {
        require "dbh.inc.php";
        // queryen henter infoen om brukeren
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
        } else {
            // lager en asociative array som lagrer rolle og navnet til brukeren
            $brukerinfo = array("brukernavn" => $result["brukernavn"], 
            "rolle" => $result["rolle"],
            "navn" => $result["navn"]);
            return ($brukerinfo);
        }
    } catch (PDOException $e) {
        return (null);
    }
}

function show_userinfo ($id) {

    if (isset($id)) {
        require_once "includes/dbh.inc.php";
        require_once "includes/common.php";
        $info = getbrukerinfo($id);
if ($info == null) {
    return("bruker_id $id finnes ikke");
    }
        return "<span>Logget inn som: <br> $info[navn] <br> som: $info[rolle]</span>";
    } else {
        return "Du er ikke logget inn";
    }
}
?>