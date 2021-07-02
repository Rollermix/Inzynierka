<?php
session_start();
require_once 'dbh.inc.php';
require_once 'adminfunctions.inc.php';
if(isset($_POST["submit"])) {
    $city = $_POST["city"];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $id = $_SESSION['idspot'];
    editspot($conn,$id, $city, $name, $description);
}
else {
    header("location: ../managespots.php");
    exit();
}
