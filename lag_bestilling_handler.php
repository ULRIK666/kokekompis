<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Handlekurv</title>
</head>

<body>
    <header>
        <div>
            <div class="menu-container">
                <img class="img-icon menu-icon" src="images/icon-img/menu_icon.png" alt="menu icon">
                <div class="dropdown-content">

                    <a href="faq.php">FAQ</a>
                    <a href="log_inn.php">Log In</a>
                    <a href="signup.php">Sign Up</a>
                </div>
            </div>
            <a href="index.php"><img class="logo" src="images/logo/kokekompis.png" alt="menu icon"></a>
        </div>
        <div class="space_between">

            <div>
                <a href="handlekurv.php"><img class="img-icon" src="images/icon-img/handlekurv.png"
                        alt="profile icon"></a>

                <a href="log_inn.php"><img class="img-icon" src="images/icon-img/profile_icon.png"
                        alt="profile icon"></a>
                <div class="user-info">
                    <!-- forteller hvem som er logget in -->
                    <?php
                    session_start();
                    require_once "includes/common.php";
                    echo show_userinfo($_SESSION['bruker_id']);
                    ?>
                </div>
            </div>

        </div>
    </header>

    <div class="center">
        <div class="handlekurv">
            <table width='100%'>

                <?php
                require "includes/dbh.inc.php";

                //henter bruker_id for å sjekke om man er logget inn
                $bruker_id = $_SESSION['bruker_id'];
                if ($bruker_id == 0) {
                    echo "Du må være logget inn for å bestille. <br>Trykk på login-knappen øverst til høyre\n";
                    return;
                }

                //sql query for å hente oppskrifter i bestilling 
                $query = "SELECT * FROM handlekurv WHERE handlekurv.bruker_id = :bruker_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":bruker_id", $bruker_id);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


                if (empty($result)) {
                    echo "<p>Ingen oppskrifter i handlekurven</p>";
                } else {

                    $bestilling_dato = date("Y-m-d H:i:s");

                    $query1 = "INSERT INTO bestilling (handle_tid, bruker_id) values (:bestilling_dato, :bruker_id)";
                    $stmt1 = $pdo->prepare($query1);
                    $stmt1->bindParam(":bruker_id", $bruker_id);
                    $stmt1->bindParam(":bestilling_dato", $bestilling_dato);
                    $stmt1->execute();
                    $bestilling_id = $pdo->lastInsertId();

                    echo "Ditt bestillingsnummer er $bestilling_id<br>\n";
                    echo "<h3>Bestilling:</h3>\n";



                    $query2 = "SELECT handlekurv.pris_i_handlekurv, handlekurv.oppskrift_id, handlekurv.id, oppskrifter.tittel AS tittel
                    FROM handlekurv
                    INNER JOIN oppskrifter ON oppskrifter.id = handlekurv.oppskrift_id WHERE handlekurv.bruker_id = :bruker_id";
                    $stmt2 = $pdo->prepare($query2);
                    $stmt2->bindParam(":bruker_id", $bruker_id);
                    $stmt2->execute();

                    $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);


                    $total = 0;
                    foreach ($result as $oppskrift) {
                        $query3 = "INSERT INTO oppskrift_i_bestilling (bestilling_id, oppskrift_id, pris_i_bestilling) 
                                   VALUES (:bestilling_id, :oppskrift_id, :pris_i_bestilling)";
                        $stmt3 = $pdo->prepare($query3);
                        $stmt3->bindParam(":bestilling_id", $bestilling_id);
                        $stmt3->bindParam(":oppskrift_id", $oppskrift['oppskrift_id']);
                        $stmt3->bindParam(":pris_i_bestilling", $oppskrift['pris_i_handlekurv']);
                        $stmt3->execute();

                        $query4 = "DELETE FROM handlekurv 
                                   WHERE bruker_id = :bruker_id AND id = :id";
                        $stmt4 = $pdo->prepare($query4);
                        $stmt4->bindParam(":bruker_id", $bruker_id);
                        $stmt4->bindParam(":id", $oppskrift['id']);
                        $stmt4->execute();

                        $total += $oppskrift['pris_i_handlekurv'];
                        $tittel = $oppskrift['tittel'];
                        echo "<tr><td><a href='oppskrift_side.php?id=$oppskrift[oppskrift_id]'>$tittel</a></td>";
                        echo "<td>$oppskrift[pris_i_handlekurv] kr  </td>\n";
                        echo "</tr>";
                    }
                    echo "<tr>";
                    echo "<td>Total:</td>\n";
                    echo "<td>$total kr</td>\n";
                    echo "</tr>";
                    echo "</table>";
                }
                ?>
        </div>
    </div>
</body>

</html>