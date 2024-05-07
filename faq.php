<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kokekompis</title>
    <link rel="stylesheet" href="css/style.css">
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
        <div class="faq_questions">
            <div class="faq-header">Frequently Asked Questions</div>
            <div>
                <h3>Trykk på spørsmålene under for å få <br> svar på det du lurer på</h3>
            </div>

            <div class="faq-content">
                <?php
                // Include database connection
                include 'includes/dbh.inc.php';

                // Query to fetch questions from database
                $query = "SELECT spørsmål_tittel, spørsmål_svar FROM faq";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($result !== false && $stmt->rowCount() > 0) {
                    // Output data of each row
                    foreach ($result as $row) {
                        // Bruk spørsmålets tittel som id
                        $id = strtolower(str_replace(' ', '_', $row["spørsmål_tittel"]));

                        echo '<div class="faq-question">';
                        echo '<input type="checkbox" id="q_' . $id . '" class="panel">';
                        echo '<div class="plus">+</div>';
                        echo '<label for="q_' . $id . '" class="panel-title">' . $row["spørsmål_tittel"] . '</label>';
                        echo '<div class="panel-content">' . $row["spørsmål_svar"] . '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No questions found in the FAQ.";
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>