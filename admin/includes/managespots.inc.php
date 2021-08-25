<?php
session_start();
require_once 'dbh.inc.php';
require_once 'adminfunctions.inc.php';
if (isset($_POST["submit"])) {
    $check = 'Wybierz miasto...';
    $city = $_POST["city"];
    $name = $_POST['name'];
    $description = $_POST['description'];

    if ($city === $check) {
        header("location: ../managespots.php?error=errorinputcity");
        exit();
    }
    if (emptyInputAdd($name) !== false) {
        header("location: ../managespots.php?error=emptyinputspot");
        exit();
    }
    addspot($conn, $city, $name, $description);
}
else if(isset($_GET["delete"])) {

    $nazwa = ($_GET["delete"]);
    {
        deleteSpot($conn,$nazwa);
    }
}
else {
    header("location: ../managespots.php");
    exit();
}