<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <a href="logout.php" class="btn btn-danger my-2">Log Out</a>
        <h1>Admini paneeli asjanduse värk</h1>
        <hr>
        <h2>Registreerimis asjandus, ma ei saa aru mis see on, ja kuidas see töötab aga see töötab  </h2>
        <form action="#" method="get">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label for="parool" class="form-label">Password:</label>
                <input type="password" class="form-control" name="parool" id="parool" required>
            </div>
            <button type="submit" class="btn btn-success">Register</button>
        </form>

        <?php
        if (!empty($_GET['username']) && !empty($_GET['parool'])) {
            $username = htmlspecialchars($_GET['username']);
            $parool = htmlspecialchars($_GET['parool']);

            $asi = $conn->prepare("SELECT COUNT(*) as count FROM kasutajad WHERE kasutaja = ?");
            $asi->bind_param("s", $username);
            $asi->execute();
            $result = $asi->get_result();
            $user_count = $result->fetch_assoc()['count'];

            if ($user_count > 0) {
                echo "<div class='alert alert-danger mt-3'>Kas sa pole juba seda kontot endale teinud, võiks mäletada kus teil kontod on tehtud.</div>";
            } else {
                if (strlen($parool) < 8) {
                    echo "<div class='alert alert-warning mt-3'>Mingi lahe error, kui said selle, siis palju õnne võitsite 50€ klikkige alloleval lingile et endale 50€ saada. <br> <a href='https://www.youtube.com/watch?v=dQw4w9WgXcQ' target='_blank'>ainultvõitjatele</a> <br> Tegelikult peab parrol olema 8 ühikut pikk:)</div>";                } else {
                    $hashed = password_hash($parool, PASSWORD_DEFAULT);
                    $asi = $conn->prepare("INSERT INTO kasutajad (kasutaja, parool) VALUES (?, ?)");
                    $asi->bind_param("ss", $username, $hashed);

                    if ($asi->execute()) {
                        header("Location: admin.php");
                        exit;
                    } else {
                        echo "<div class='alert alert-danger mt-3'>Mingi lahe error, kui said selle, siis palju õnne võitsite 50€ klikkige alloleval lingile et endale 50€ saada. <br> <a href='https://www.youtube.com/watch?v=dQw4w9WgXcQ' target='_blank'>ainultvõitjatele</a></div>";
                    }
                    $asi->close();
                }
            }
        }
        ?>

        <?php $conn->close(); ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEy" crossorigin="anonymous"></script>
