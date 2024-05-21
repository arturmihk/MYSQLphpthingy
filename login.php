<?php
require_once 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2>Admin Login</h2>
        <hr>
        <form action="#" method="get">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="mb-3">
                <label for="parool" class="form-label">Password:</label>
                <input type="password" class="form-control" name="parool" id="parool" required>
            </div>
            <button type="submit" class="btn btn-success">Login</button>
        </form>

        <?php
        if (!empty($_GET['username']) && !empty($_GET['parool'])) {
            $username = htmlspecialchars($_GET['username']);
            $parool = htmlspecialchars($_GET['parool']);

            $asi = $conn->prepare("SELECT parool FROM kasutajad WHERE kasutaja = ?");
            $asi->bind_param("s", $username);
            $asi->execute();
            $result = $asi->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashed = $row['parool'];

                if (password_verify($parool, $hashed)) {
                    $_SESSION['logged_in'] = true;
                    header("Location: admin.php");
                    exit;
                } else {
                    echo "<div class='alert alert-danger mt-3'>Incorrect password!</div>";
                }
            } else {
                echo "<div class='alert alert-danger mt-3'>User not found!</div>";
            }
            $asi->close();
        }
        ?>

        <?php $conn->close(); ?>
    </div>
</body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMx" crossorigin="anonymous"></script>
