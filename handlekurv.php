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
                    require_once "includes/dbh.inc.php";
                    require_once "includes/common.php";
                    if (isset($_SESSION['bruker_id'])) {
                        $bruker_id = show_userinfo($_SESSION['bruker_id']);
                        if ($bruker_id) {
                            echo $bruker_id;

                        } else {
                            echo "ukjent feil, fikk ikke svar fra show user info";
                        }
                    } else {
                        echo "Du er ikke logget inn";
                    }
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
                if (isset($_SESSION['bruker_id'])) {

                $bruker_id = $_SESSION['bruker_id'];
                if ($bruker_id == 0) {
                    echo "Du må være logget inn for å bestille. <br>Trykk på login-knappen øverst til høyre\n";
                    return;
                }
            }
 
                //sql query for å hente oppskrifter i bestilling 
                $query = "SELECT handlekurv.pris_i_handlekurv, oppskrifter.id, oppskrifter.tittel 
                FROM handlekurv
                INNER JOIN oppskrifter ON oppskrifter.id = handlekurv.oppskrift_id WHERE handlekurv.bruker_id = :bruker_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":bruker_id", $bruker_id);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


                if (empty($result)) {
                    echo "<p>Handlekurven er tom</p>";
                    return;
                }

                echo "<h1>Din handlekurv:</h1>";
                echo "<table>";
                echo "<tr>";
                echo "<th>Oppskrift</th>";
                echo "<th>Pris</th>";
                echo "</tr>";

                $total = 0;
                foreach ($result as $oppskrift) {
                    $pris = $oppskrift['pris_i_handlekurv'];
                    $oppskrift_id = $oppskrift['id'];
                    $oppskrift_tittel = $oppskrift['tittel'];
                    $total += $pris;

                    echo "<tr>";
                    echo "<td><a href='oppskrift_side.php?id=$oppskrift_id'>$oppskrift_tittel</a></td>";
                    echo "<td>$pris kr  </td>\n";
                    echo "</tr>";
                }
                echo "<tr>";
                echo "<td>Total:</td>";
                echo "<td>$total kr</td>";
                echo "</tr>";
                echo "</table>";

                echo "<a href='lag_bestilling_handler.php' class='button'>Lag bestilling</a>";


                ?>
        </div>
    </div>
</body>

</html>