<?php
session_start();
        require_once "includes/common.php";
        if (isset($_SESSION['bruker_id'])) {
            $userinfo = getbrukerinfo($_SESSION['bruker_id']);
            if ($userinfo != null) {
                if ($userinfo["rolle"] != "admin") {
                    echo "har ikke lov til å se brukerliste siden du ikke er admin bruker";
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kokekompis</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.8.1/css/foundation.min.css"
        integrity="sha512-QuI0HElOtzmj6o/bXQ52phfzjVFRAhtxy2jTqsp85mdl1yvbSQW0Hf7TVCfvzFjDgTrZostqgM5+Wmb/NmqOLQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }

        .btn-danger {
            background-color: #ff0000;
            color: #fff;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }
    </style>
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
                <a href="handlekurv.php"><img class="img-icon" src="images/icon-img/handlekurv.png"
                        alt="profile icon"></a>

                <a href="log_inn.php"><img class="img-icon" src="images/icon-img/profile_icon.png"
                        alt="profile icon"></a>
                <div class="user-info">
                    <!-- forteller hvem som er logget in -->

                    <?php
                    require "includes/dbh.inc.php";
                    require_once "includes/common.php";
                    echo show_userinfo($_SESSION['bruker_id']);
                    ?>

                </div>
            </div>

        </div>
    </header>


    <h2>Brukerliste</h2>

    <table class="styled-table">
        <tr>
            <th class="table-header">Bruker ID</th>
            <th class="table-header">Brukernavn</th>
            <th class="table-header">Navn</th>
            <th class="table-header">Rolle</th>
            <th class="table-header">Bytt rolle</th>
            <th class="table-header">Slett</th>
        </tr>

        <?php
        require_once "includes/dbh.inc.php";

        $sql = "SELECT brukere.id AS bruker_id, brukere.brukernavn, brukere.navn, roller.rolle, brukere.rolle_id
        FROM brukere
        INNER JOIN roller ON brukere.rolle_id = roller.id ORDER BY brukere.navn ASC";
        $stmt = $pdo->query($sql);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['bruker_id'] . "</td>";
            echo "<td>" . $row['brukernavn'] . "</td>";
            echo "<td>" . $row['navn'] . "</td>";
            echo "<td>" . $row['rolle'] . "</td>";

            $sql_roles = "SELECT rolle, id FROM roller WHERE id <> :rolle_id";
            $stmt_roles = $pdo->prepare($sql_roles);
            $stmt_roles->bindValue(':rolle_id', $row['rolle_id']);
            $stmt_roles->execute();
            $available_roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);
// ikke vise slette og endre knapper for deg selv
if ($row['bruker_id'] != $_SESSION['bruker_id']) { 
    echo "<td>";

            foreach ($available_roles as $role) {
                echo "<form action='endre_bruker_handler.php' method='POST' style='display: inline;'>
                <input type='hidden' name='handling' value='endre'>
                <input type='hidden' name='bruker_id' value='" . $row['bruker_id'] . "'>
                <input type='hidden' name='rolle_id' value='" . $role['id'] . "'>
                <button class='btn btn-primary' type='submit' name='rolle' value='$role[id]'>Bytt til $role[rolle]</button>
                </form>";
            }

            echo "</td>";
            echo "<td>
            <form action='endre_bruker_handler.php' method='POST' style='display: inline;'>
            <input type='hidden' name='handling' value='slett'>
            <input type='hidden' name='bruker_id' value='" . $row['bruker_id'] . "'>
            <button class='btn btn-danger' type='submit'>Slett bruker</button>
            </form>
          </td>";
            echo "</tr>";
        } else {
            echo "<td></td>";
            echo "<td></td>";
            echo "</tr>";
        }
    }
        ?>


    </table>

    <script src="js/script.js"></script>

</body>

</html>