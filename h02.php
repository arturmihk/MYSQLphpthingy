// index.php

<?php
include 'config.php';


$query1 = "SELECT * FROM albumid LIMIT 10";
$result1 = mysqli_query($conn, $query1);

echo "<h2>Albumid:</h2>";
echo "<table border='1'>";
echo "<tr><th>Albumi ID</th><th>Artist</th><th>Album</th><th>Aasta</th><th>Hind</th></tr>";
while ($row = mysqli_fetch_assoc($result1)) {
    echo "<tr><td>{$row['id']}</td><td>{$row['artist']}</td><td>{$row['album']}</td><td>{$row['aasta']}</td><td>{$row['hind']}</td></tr>";
}
echo "</table>";


$query2 = "SELECT artist, album FROM albumid ORDER BY artist ASC LIMIT 10";
$result2 = mysqli_query($conn, $query2);

echo "<h2>Artist ja albumid (sorteeritud):</h2>";
echo "<table border='1'>";
echo "<tr><th>Artist</th><th>Album</th></tr>";
while ($row = mysqli_fetch_assoc($result2)) {
    echo "<tr><td>{$row['artist']}</td><td>{$row['album']}</td></tr>";
}
echo "</table>";


$query3 = "SELECT artist, album FROM albumid WHERE aasta >= 2010";
$result3 = mysqli_query($conn, $query3);

echo "<h2>2010. aastal ja hiljem välja antud albumid:</h2>";
echo "<table border='1'>";
echo "<tr><th>Artist</th><th>Album</th></tr>";
while ($row = mysqli_fetch_assoc($result3)) {
    echo "<tr><td>{$row['artist']}</td><td>{$row['album']}</td></tr>";
}
echo "</table>";


$query4 = "SELECT COUNT(DISTINCT album) AS albumite_arv, AVG(hind) AS keskmine_hind, SUM(hind) AS kogu_väärtus FROM albumid";
$result4 = mysqli_query($conn, $query4);
$row = mysqli_fetch_assoc($result4);

echo "<h2>Andmebaasis olevate albumite statistika:</h2>";
echo "<p>Erinevate albumite arv: {$row['albumite_arv']}</p>";
echo "<p>Keskmine hind: {$row['keskmine_hind']} EUR</p>";
echo "<p>Koguväärtus: {$row['kogu_väärtus']} EUR</p>";


$query5 = "SELECT album FROM albumid WHERE aasta = (SELECT MIN(aasta) FROM albumid)";
$result5 = mysqli_query($conn, $query5);

echo "<h2>Kõige vanema albumi nimed:</h2>";
echo "<ul>";
while ($row = mysqli_fetch_assoc($result5)) {
    echo "<li>{$row['album']}</li>";
}
echo "</ul>";


$query6 = "SELECT artist, album, hind FROM albumid WHERE hind > (SELECT AVG(hind) FROM albumid)";
$result6 = mysqli_query($conn, $query6);

echo "<h2>Albumid, mille hind on keskmisest suurem:</h2>";
echo "<table border='1'>";
echo "<tr><th>Artist</th><th>Album</th><th>Hind</th></tr>";
while ($row = mysqli_fetch_assoc($result6)) {
    echo "<tr><td>{$row['artist']}</td><td>{$row['album']}</td><td>{$row['hind']}</td></tr>";
}
echo "</table>";

mysqli_close($conn);
?>
