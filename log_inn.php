<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.8.1/css/foundation.min.css"
        integrity="sha512-QuI0HElOtzmj6o/bXQ52phfzjVFRAhtxy2jTqsp85mdl1yvbSQW0Hf7TVCfvzFjDgTrZostqgM5+Wmb/NmqOLQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <a href="#">About</a>
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
        <div class="box">
            <div class="innhold_plassering">

                <h3>Login</h3>
                <?php
                session_start();

                //henter error meldingen
                if (isset($_SESSION['error_message'])) {
                    echo '<p class="error-message">' . $_SESSION['error_message'] . '</p>';
                    unset($_SESSION['error_message']);
                }
                ?>

                <form action="includes/loginhandler.inc.php" method="POST">
                    <input class="input_width" type="text" name="brukernavn" placeholder="Username" requierd>
                    <input class="input_width" type="password" name="passord" placeholder="Password" requiered>
                    <button class="button">Login</button> <br>
                    <a href="signup.php">Har ikke bruker? <br> Signup</a>
                </form>
            </div>
        </div>
    </div>


</body>

</html>