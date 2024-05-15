<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
    <title>Loginn</title>
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
        <div class="box">
            <div class="innhold_plassering">

                <h3>Login</h3>
                <?php

                //henter error meldingen
                if (isset($_SESSION['error_message'])) {
                    echo '<p class="error-message">' . $_SESSION['error_message'] . '</p>';
                    unset($_SESSION['error_message']);
                }
                ?>

                <form action="includes/loginhandler.inc.php" method="POST">
                    <input class="input_text" class="input_width" type="text" name="brukernavn" placeholder="Username" requierd>
                    <input class="input_text" class="input_width" type="password" name="passord" placeholder="Password" requiered>
                    <button class="button">Login</button> <br>
                    <a href="signup.php">Har ikke bruker? <br> Signup</a>
                </form>
            </div>
        </div>
    </div>


</body>

</html>