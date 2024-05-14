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
                        <input class="input_text" type="text" id="searchInput" placeholder="Søk etter oppskrift">
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
                    require_once "includes/dbh.inc.php";
                    require_once "includes/common.php";
                    echo show_userinfo($_SESSION['bruker_id']);
                    ?>

                </div>
            </div>

        </div>
    </header>

    <div class="kategori_overskrift">
        <h1>legg til oppskrift</h1>
    </div>



    <div class="center">
        <div class="box">
            <div class="innhold_plassering">

                <form action="lagre_oppskrift_handler.php" method="POST">
                    <input class="input_text"  class="input_width" type="text" name="tittel" placeholder="Matrett" requierd>
                    <select class="input_text" name="kategori_id">
                        <?php
                    require "includes/dbh.inc.php";

                        // henter kategorier fra databasen
                        $kategoriQuery = "SELECT * FROM kategori";
                        $stmt = $pdo->prepare($kategoriQuery);
                        $stmt->execute();
                        $kategorier = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $options = "";
                        //skjekker om det er kategorier og skriver de ut hvis det er det 
                        if (empty($kategorier)) {
                                echo "<p>Fant ikke noen kategorier</p>";
                        } else {
                            //    echo "<div class='matkategori' data-kategori-id='alle'>Alle oppskrifter</div>";
                            foreach ($kategorier as $kategori) {
                                $kategori_id = $kategori['id'];
                                $kategori_navn = $kategori['navn'];
                                $options .= "<option value='$kategori_id'>$kategori_navn</option>\n";
                            }
                        }
                        echo $options;

                        ?>

                    </select>
                    <select class="input_text" name="vanskelighetsgrad">
                        <option value="lett">Lett</option>
                        <option value="middels">Middels</option>
                        <option value="vannsklig">Vansklig</option>
                    </select>
                    <input class="input_text" type="number" name="anbefalt_porsjoner" placeholder="Anbefalt porsjoner" requierd>
                    <input class="input_text" type="number" name="pris" placeholder="Pris" requiered>
                    <input class="input_text" type="number" name="beregnet_tid" placeholder="Beregnet tid" requierd>
                    <textarea name="fremgangsmåte" placeholder="Fremgangsmåte" cols="50" rows="5"></textarea>
                    <button class="button">Legg til oppskrift</button> <br>
                </form>
            </div>
        </div>
    </div>




    <script src="js/script.js"></script>

</body>

</html>