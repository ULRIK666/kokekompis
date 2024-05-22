<?php 
// lager database forbinelsen
$dsn = "mysql:host=localhost;dbname=kokekompis";
$dbusername = "kokekompis";
$dbpassword = "cheese3.14";


try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "connection failed: " . $e->getMessage();
}

