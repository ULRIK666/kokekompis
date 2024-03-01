<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>handlekurv</title>
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
                    <a href="#">About</a>
                </div>
            </div>
            <a href="index.php"><img class="logo" src="images/logo/kokekompis.png" alt="menu icon"></a>
        </div>
        <div class="space_between">
            <div class="søke_input">
                <div class="space_between">
                    <img class="img-icon" src="images/icon-img/search_icon.png" alt="søke ikon">
                    <input type="text" id="searchInput" placeholder="Søk etter oppskrift">
                </div>
            </div>
            <div>
                <a href="handlekurv.php"><img class="img-icon" src="images/icon-img/handlekurv.png"
                        alt="profile icon"></a>
                <a href="log_inn.php"><img class="img-icon" src="images/icon-img/profile_icon.png"
                        alt="profile icon"></a>
            </div>
        </div>
    </header>
    
    <div class="center">
        <div class="handlekurv">
            <table width='100%'>

                <?php
                require_once "includes/dbh.inc.php";
                session_start();
                $kunde_id = $_SESSION['kunde_id'];
                if ($kunde_id == 0) {
                    echo "Du må være logget inn for å bestille. <br>Trykk på login-knappen øverst til høyre\n";
                    return;
                }
                //ting å gjøre ved bestilling:
                //1. finne alle radene fra produkt_i_handlekurv, vise feilmelding hvis den er tom
                //2. lage ny rad i tabellen bestilling
                //3. insert ny rad i produkt_i_bestilling (kopier fra produkt_i_handlekurv)
                //4. slette gammel rad fra produkt_i_handlekurv
                //5. vise en kvitering side 
                
                //1. select fra handlekurven, vise feilmelding hvis den er tom
                $query1 = "SELECT * FROM produkt_i_handlekurv WHERE produkt_i_handlekurv.kunde_id=:kunde_id";
                $stmt = $pdo->prepare($query1);
                $stmt->bindParam(":kunde_id", $kunde_id);
                $stmt->execute();
                $handlekurv_result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($handlekurv_result)) {
                    echo "<p>Ingen produkter i handlekurven - du kan ikke lage en bestilling</p>";
                    return;
                }

                //2. lage ny rad i tabellen bestilling
                $query2 = "INSERT INTO bestilling (dato, kunde_id) values (curdate(), :kunde_id)";
                $stmt2 = $pdo->prepare($query2);
                $stmt2->bindParam(":kunde_id", $kunde_id);
                $stmt2->execute();
                $bestilling_id = $pdo->lastInsertId(); // får tak i id som autoimkrementert
                echo "Ditt bestillingsnummer er $bestilling_id<br>\n";
                echo "<h3>Bestilling:</h3>\n";

                foreach ($handlekurv_result as $hk) {
                    //3. insert ny rad i produkt_i_bestilling (kopier fra produkt_i_handlekurv)
                    $query2 = "INSERT INTO produkt_i_bestilling (bestilling_id, produkt_id, antall, pris_per_enhet)
                               values (:bestilling_id, :produkt_id, :antall, :pris_per_enhet)";
                    $antall = $hk['antall'];
                    $produkt_id = $hk['produkt_id'];
                    $pris_per_enhet = $hk['pris_per_enhet'];
                    $stmt2 = $pdo->prepare($query2);
                    $stmt2->bindParam(":bestilling_id", $bestilling_id);
                    $stmt2->bindParam(":produkt_id", $produkt_id);
                    $stmt2->bindParam(":antall", $antall);
                    $stmt2->bindParam(":pris_per_enhet", $pris_per_enhet);
                    $stmt2->execute();
                    //4. slette gammel rad fra produkt_i_handlekurv
                    
                    $query2 = "DELETE FROM produkt_i_handlekurv WHERE kunde_id = :kunde_id AND produkt_id = :produkt_id";
                    $stmt2 = $pdo->prepare($query2);
                    $stmt2->bindParam(":kunde_id", $hk['kunde_id']);
                    $stmt2->bindParam(":produkt_id", $hk['produkt_id']);
                    $stmt2->execute();

                }

                //5. vise en kvitering side 
                $query = "SELECT * FROM produkt_i_bestilling LEFT JOIN produkt on produkt_i_bestilling.produkt_id = produkt.id
                          WHERE bestilling_id=:bestilling_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":bestilling_id", $bestilling_id);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($result)) {
                    echo "<p>Ingen produkter i bestilling $bestilling_id</p>";
                    return;
                }

                $total = 0;
                foreach ($result as $p) {
                    $varepris = $p['pris_per_enhet'] * $p['antall'];
                    $total += $varepris;
                    echo "      <tr><td><a href='handle_side.php?id=${p['id']}'>${p['navn']}</a></td>
                        <td>${p['antall']} stk </td>\n";

                    echo "<td>${p['pris_per_enhet']} kr  </td>\n";
                    echo "<td>$varepris kr</td>\n";
                    echo "</tr>";

                }
                echo "</table>";
                echo "<p>Total: $total kr</p>";
                ?>
        </div>
    </div>
</body>

</html>