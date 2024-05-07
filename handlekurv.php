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

        <div>
            <a href="handlekurv.php"><img class="img-icon" src="images/icon-img/handlekurv.png" alt="profile icon"></a>
            <a href="log_inn.php"><img class="img-icon" src="images/icon-img/profile_icon.png" alt="profile icon"></a>
        </div>
    </header>
    <div class="center">
        <div class="handlekurv">
            <table width='100%'>

                <?php
                require_once "includes/dbh.inc.php";
                session_start();
                $kunde_id = $_SESSION['bruker_id'];
                if ($kunde_id == 0) {
                    echo "Du må være logget inn for å bestille. <br>Trykk på login-knappen øverst til høyre\n";
                    return;
                }

                $query = "SELECT oppskrift_i_bestilling.oppskrift_id 
                FROM oppskrift_i_bestilling 
                INNER JOIN bestilling ON oppskrift_i_bestilling.bestilling_id = bestilling.bestilling_id
                WHERE bestilling.bruker_id = :bruker_id";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(":bruker_id", $bruker_id);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      

                if (empty($result)) {
                    echo "<p>Ingen produkter i handlekurven</p>";
                    return;
                }

                $query2 = "INSERT INTO bestilling (dato, bruker_id) values (CURDATE(), :kunde_id)";
                $stmt2 = $pdo->prepare($query2);
                $stmt2->bindParam(":kunde_id", $kunde_id);
                $stmt2->execute();
                $bestilling_id = $pdo->lastInsertId();
                echo "Ditt bestillingsnummer er $bestilling_id<br>\n";
                echo "<h3>Bestilling:</h3>\n";

                foreach ($result as $oppskrift) {
                    $query3 = "INSERT INTO produkt_i_bestilling (bestilling_id, oppskrift_id) 
                               VALUES (:bestilling_id, :oppskrift_id)";
                    $stmt3 = $pdo->prepare($query3);
                    $stmt3->bindParam(":bestilling_id", $bestilling_id);
                    $stmt3->bindParam(":oppskrift_id", $oppskrift['oppskrift_id']);
                    $stmt3->execute();

                    $query4 = "DELETE FROM oppskrift_i_bestilling 
                               WHERE kunde_id = :kunde_id AND oppskrift_id = :oppskrift_id";
                    $stmt4 = $pdo->prepare($query4);
                    $stmt4->bindParam(":kunde_id", $kunde_id);
                    $stmt4->bindParam(":oppskrift_id", $oppskrift['oppskrift_id']);
                    $stmt4->execute();
                }

                $query5 = "SELECT * FROM produkt_i_bestilling 
                           LEFT JOIN oppskrifter ON produkt_i_bestilling.oppskrift_id = oppskrifter.id
                           WHERE bestilling_id = :bestilling_id";
                $stmt5 = $pdo->prepare($query5);
                $stmt5->bindParam(":bestilling_id", $bestilling_id);
                $stmt5->execute();
                $result = $stmt5->fetchAll(PDO::FETCH_ASSOC);

                if (empty($result)) {
                    echo "<p>Ingen produkter i bestilling $bestilling_id</p>";
                    return;
                }

                $total = 0;
                foreach ($result as $oppskrift) {
                    $total += $oppskrift['pris'];
                    echo "<tr><td><a href='oppskrift_side.php?id=${oppskrift['id']}'>${oppskrift['tittel']}</a></td>
                        <td>${oppskrift['antall']} stk </td>\n";
                    echo "<td>${oppskrift['pris']} kr  </td>\n";
                    echo "</tr>";
                }
                echo "</table>";
                echo "<p>Total: $total kr</p>";
                ?>
        </div>
    </div>
</body>

</html>
