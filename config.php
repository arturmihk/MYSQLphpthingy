<?php
$kasutaja = "artur";
$server = "localhost";
$andmebaas = "muusikapood_artur";
$password = "Passw0rd";

$conn = mysqli_connect($server, $kasutaja, $password, $andmebaas);

if (!$conn){
    die("connecion die wadefak");
}



?>