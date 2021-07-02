<?php

if (isset($_POST["submit"])) {
    $check = 'Wybierz miasto...';
    $city = $_POST["city"];
    $name = $_POST['name'];
    $description = $_POST['description'];
    require_once 'dbh.inc.php';
    require_once 'adminfunctions.inc.php';
    if ($city === $check) {
        header("location: ../managespots.php?error=errorinputcity");
        exit();
    }
    if (emptyInputAddCity($name) !== false) {
        header("location: ../managespots.php?error=emptyinputspot");
        exit();
    }
    addspot($conn, $city, $name, $description);
} else {
    header("location: ../managespots.php");
    exit();
}