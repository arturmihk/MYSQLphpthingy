<?php
include("config.php");
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uudised</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>-UUDISED-</h1>
        <hr>

        <?php
        $uudiseid_lehel = 6;

        $uudiseid_kokku_paring = "SELECT COUNT(id) FROM uudised";
        $lehtede_vastus = mysqli_query($conn, $uudiseid_kokku_paring);
        $uudiseid_kokku = mysqli_fetch_array($lehtede_vastus);
        $lehti_kokku = ceil($uudiseid_kokku[0] / $uudiseid_lehel);

        echo 'Lehekülgi kokku: ' . $lehti_kokku . '<br>';
        echo 'Uudiseid lehel: ' . $uudiseid_lehel . '<br>';

        // Kasutaja valik
        $leht = isset($_GET['leht']) ? (int)$_GET['leht'] : 1;

        $start = ($leht - 1) * $uudiseid_lehel;

        // Andmebaasist andmed
        $paring = "SELECT * FROM uudised LIMIT $start, $uudiseid_lehel";
        $vastus = mysqli_query($conn, $paring);

        // Väljastamine
        while ($rida = mysqli_fetch_assoc($vastus)) {
            echo '<h3>' . htmlspecialchars($rida['pealkiri']) . '</h3>';
            echo '<p>' . nl2br(htmlspecialchars($rida['uudis'])) . '</p>';
        }

        // Kuvame lingid
        echo '<nav>';
        echo '<ul class="pagination">';

        $eelmine = $leht - 1;
        $jargmine = $leht + 1;

        if ($leht > 1) {
            echo '<li class="page-item"><a class="page-link" href="?leht=' . $eelmine . '">Eelmine</a></li>';
        }

        for ($i = 1; $i <= $lehti_kokku; $i++) {
            if ($i == $leht) {
                echo '<li class="page-item active"><a class="page-link" href="?leht=' . $i . '">' . $i . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="?leht=' . $i . '">' . $i . '</a></li>';
            }
        }

        if ($leht < $lehti_kokku) {
            echo '<li class="page-item"><a class="page-link" href="?leht=' . $jargmine . '">Järgmine</a></li>';
        }

        echo '</ul>';
        echo '</nav>';

        // Sulgeme ühenduse
        $conn->close();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
