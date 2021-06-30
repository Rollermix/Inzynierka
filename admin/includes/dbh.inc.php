<?php
$serverName ="localhost";
$dBUserName = "root";
$dbPassword = "";
$dbName = "inzynierka";

$conn = mysqli_connect($serverName,$dBUserName,$dbPassword,$dbName);

if(!$conn)
{
    die("Nie udało się połączyć z bazą: " . mysqli_connect_error());
}
