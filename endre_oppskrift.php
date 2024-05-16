<?php
session_start();
        require_once "includes/common.php";
        if (isset($_SESSION['bruker_id'])) {
            $userinfo = getbrukerinfo($_SESSION['bruker_id']);
            if ($userinfo != null) {
                if ($userinfo["rolle"] != "admin" && $userinfo["rolle"] != "kokk") {
                    echo "har ikke lov til å endre oppskrifter siden du ikke er admin eller kokk";
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
                    require_once "includes/dbh.inc.php";
                    require_once "includes/common.php";
                    echo show_userinfo($_SESSION['bruker_id']);
                    ?>

                </div>
            </div>

        </div>
    </header>
    <?php
    require "includes/dbh.inc.php";

    if ($_GET['id']) {
        $id = $_GET['id'];

        // henter data for oppskriften 
        $oppskriftQuery = "SELECT * FROM oppskrifter WHERE id = :id";
        $stmt = $pdo->prepare($oppskriftQuery);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $oppskrift = $stmt->fetch(PDO::FETCH_ASSOC);

        //definerer forskjellig informasjon om oppskriften 
        $bilde_url = $oppskrift['bilde_url'];
        $tittel = $oppskrift['tittel'];
        $vanskelighetsgrad = $oppskrift['vanskelighetsgrad'];
        $beregnet_tid = $oppskrift['beregnet_tid'];
        $oppskrift_id = $oppskrift['id'];
        $fremgangsmåte = $oppskrift['fremgangsmåte'];
    } else {
        // hvis id ikke er sendt med i url gi en feilmelding
        echo "<p>Mangler oppskrifts-ID i URLen</p>";
    }
    ?>

    <div class="kategori_overskrift">
        <h1>Endre oppskrift</h1>
    </div>



    <div class="center">
        <div class="box">
            <div class="innhold_plassering">
                <form action="endre_oppskrift_handler.php" method="POST">
                <input class="input_text" type="hidden" name="id" value="<?php echo $id ?>">
                    <input class="input_text"  class="input_width" type="text" name="tittel" placeholder="Matrett"
                        value="<?php echo $oppskrift['tittel']; ?>" required>
                    <select class="input_text" name="kategori_id">
                        <?php
                        // Henter kategorier fra databasen
                        $kategoriQuery = "SELECT * FROM kategori";
                        $stmt = $pdo->prepare($kategoriQuery);
                        $stmt->execute();
                        $kategorier = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        $options = "";
                        //sjekker om det er kategorier og skriver de ut hvis det er det 
                        if (empty($kategorier)) {
                            echo "<p>Fant ikke noen kategorier</p>";
                        } else {
                            foreach ($kategorier as $kategori) {
                                $kategori_id = $kategori['id'];
                                $kategori_navn = $kategori['navn'];
                                // Markerer riktig kategori basert på oppskriftens kategori
                                $selected = ($kategori_id == $oppskrift['kategori_id']) ? 'selected' : '';
                                $options .= "<option value='$kategori_id' $selected>$kategori_navn</option>\n";
                            }
                        }
                        echo $options;
                        ?>
                    </select>
                    <select class="input_text" name="vanskelighetsgrad">
                        <option value="lett" <?php if ($oppskrift['vanskelighetsgrad'] == "lett")
                            echo "selected"; ?>>Lett
                        </option>
                        <option value="middels" <?php if ($oppskrift['vanskelighetsgrad'] == "middels")
                            echo "selected"; ?>>Middels</option>
                        <option value="vannsklig" <?php if ($oppskrift['vanskelighetsgrad'] == "vanskelig")
                            echo "selected"; ?>>Vanskelig</option>
                    </select>
                    <input class="input_text" type="number" name="anbefalt_porsjoner" placeholder="Anbefalt porsjoner"
                        value="<?php echo $oppskrift['anbefalt_porsjoner']; ?>" required>
                    <input class="input_text" type="number" name="pris" placeholder="Pris" value="<?php echo $oppskrift['pris']; ?>"
                        required>
                    <input class="input_text" type="text" name="beregnet_tid" placeholder="Beregnet tid"
                        value="<?php echo $oppskrift['beregnet_tid']; ?>" required>
                    <textarea name="fremgangsmåte" placeholder="Fremgangsmåte" cols="50"
                        rows="5"><?php echo $oppskrift['fremgangsmåte']; ?></textarea>
                    <button class="button">Endre oppskrift</button> <br>
                </form>
            </div>
        </div>
    </div>




    <script src="js/script.js"></script>

</body>

</html>