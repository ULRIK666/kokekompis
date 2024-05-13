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
        th, td {
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
        <div class="space_between">
            <div class="search_and_suggestions">
                <div class="søke_input">
                    <div class="space_between">
                        <input type="text" id="searchInput" placeholder="Søk etter oppskrift">
                        <div id="searchSuggestions" class="search-suggestions"></div> <!-- Ny div for søkeforslag -->
                    </div>
                </div>
                <div class="suggestions">
                </div>
            </div>


            <div>
                <a href="handlekurv.php"><img class="img-icon" src="images/icon-img/handlekurv.png"
                        alt="profile icon"></a>

                <a href="log_inn.php"><img class="img-icon" src="images/icon-img/profile_icon.png"
                        alt="profile icon"></a>
                <div class="user-info">
                    <!-- forteller hvem som er logget in -->

                    <?php
                    session_start();
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
        <th class="table-header">Rolle</th>
        <th class="table-header">Handling</th>
    </tr>

    <?php
    require_once "includes/dbh.inc.php";

    $sql = "SELECT brukere.id AS bruker_id, brukere.brukernavn, roller.rolle
            FROM brukere
            INNER JOIN roller ON brukere.rolle_id = roller.id";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>".$row['bruker_id']."</td>";
        echo "<td>".$row['brukernavn']."</td>";
        echo "<td>".$row['rolle']."</td>";
        echo "<td>
                <form action='endre_rolle.php' method='post' style='display: inline;'>
                    <input type='hidden' name='bruker_id' value='".$row['bruker_id']."'>
                    <button class='btn btn-primary' type='submit'>Endre rolle</button>
                </form>
                <form action='slett_bruker.php' method='post' style='display: inline;'>
                    <input type='hidden' name='bruker_id' value='".$row['bruker_id']."'>
                    <button class='btn btn-danger' type='submit'>Slett bruker</button>
                </form>
              </td>";
        echo "</tr>";
    }
    ?>

</table>

    <script src="js/script.js"></script>

</body>

</html>