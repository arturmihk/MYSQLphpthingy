<?php
include("config.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['nimi']) && !empty($_GET['email']) && !empty($_GET['sonum'])) {
    $nimi = $_GET['nimi'];
    $email = $_GET['email'];
    $sonum = $_GET['sonum'];

    $to = 'arturmihk912@gmail.com';
    $subject = 'Tagasiside yl7';
    $message = $sonum;
    $headers = 'From: ' . $nimi . ' <' . $email . '>';

    if ($_GET['kood'] === $_SESSION['captchatext']) {
        if (mail($to, $subject, $message, $headers)) {
            echo "Email saadetud!<br>Täname tagasiside eest!";
            echo "<meta http-equiv=\"refresh\" content=\"2;URL='index.php'\">";
            exit();
        } else {
            echo "Teie emaili ei saadetud ära!";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <a href="login.php">LOGI SISSE</a><br>
        <a href="uudised.php">UUDISED</a>
        <h1>Tagasiside</h1>
        <hr>
        <form action="" method="get">
            <label for="nimi">Teie nimi:</label><br>
            <input type="text" name="nimi" id="nimi"><br>
            <label for="email">Teie email:</label><br>
            <input type="text" name="email" id="email"><br>
            <label for="sonum">Sõnum:</label><br>
            <textarea cols="30" rows="10" name="sonum" id="sonum"></textarea><br>
            <img src="kypsised.php" alt="CAPTCHA asi"><br>
            <label for="kood">Sisesta kood pildilt:</label><br>
            <input type="text" name="kood" id="kood"><br>
            <input type="submit" class="btn btn-success my-2" value="Saada">
        </form>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
