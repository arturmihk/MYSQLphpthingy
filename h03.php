<?php
include 'config.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['lisamine'])) {

        $artist = $_POST['artist'];
        $album = $_POST['album'];
        $aasta = $_POST['aasta'];
        $hind = $_POST['hind'];


        $query = "INSERT INTO albumid (artist, album, aasta, hind) VALUES ('$artist', '$album', '$aasta', '$hind')";


        if (mysqli_query($conn, $query)) {
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        }
    }

    elseif (isset($_POST['muutmine'])) {
        $id = $_POST['id'];

        $artist = $_POST['artist'];
        $album_name = $_POST['album'];
        $aasta = $_POST['aasta'];
        $hind = $_POST['hind'];


        $query = "UPDATE albumid SET artist='$artist', album='$album_name', aasta='$aasta', hind='$hind' WHERE id=$id";


        if (mysqli_query($conn, $query)) {
            header("Location: {$_SERVER['PHP_SELF']}");
            exit;
        }
    }
}


if (isset($_GET['kustuta'])) {
    $id = $_GET['kustuta'];


    $query = "DELETE FROM albumid WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        header("Location: {$_SERVER['PHP_SELF']}");
        exit;
    }
}


$query = "SELECT * FROM albumid";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Albumid</title>
</head>
<body>
    <h2>Kõik albumid:</h2>
    <table border='1'>
        <tr>
            <th>Albumi ID</th>
            <th>Artist</th>
            <th>Album</th>
            <th>Aasta</th>
            <th>Hind</th>
            <th></th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['artist']; ?></td>
            <td><?php echo $row['album']; ?></td>
            <td><?php echo $row['aasta']; ?></td>
            <td><?php echo $row['hind']; ?></td>
            <td>
                <a href="?kustuta=<?php echo $row['id']; ?>">Kustuta</a> |
                <a href="?muuda=<?php echo $row['id']; ?>">Muuda</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>Lisa uus album:</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Artist: <input type="text" name="artist"><br>
        Album: <input type="text" name="album"><br>
        Aasta: <input type="text" name="aasta"><br>
        Hind: <input type="text" name="hind"><br>
        <input type="submit" name="lisamine" value="Lisa">
    </form>

    <h2>Muuda albumit:</h2>
    <?php if (isset($_GET['muuda'])): ?>
    <?php
        $id = $_GET['muuda'];
        $query = "SELECT * FROM albumid WHERE id=$id";
        $result = mysqli_query($conn, $query);
        $album = mysqli_fetch_assoc($result);
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        Artist: <input type="text" name="artist" value="<?php echo $album['artist']; ?>"><br>
        Album: <input type="text" name="album" value="<?php echo $album['album']; ?>"><br>
        Aasta: <input type="text" name="aasta" value="<?php echo $album['aasta']; ?>"><br>
        Hind: <input type="text" name="hind" value="<?php echo $album['hind']; ?>"><br>
        <input type="submit" name="muutmine" value="Muuda">
    </form>
    <?php endif; ?>
</body>
</html>

<?php mysqli_close($conn); ?>
