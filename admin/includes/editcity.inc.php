<?php
session_start();
require_once 'dbh.inc.php';
require_once 'adminfunctions.inc.php';
if(isset($_POST["submit"])) {
    $voivodship = $_POST["voivodship"];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $id = $_SESSION['idcity'];
    editcity($conn,$id, $voivodship, $name, $description);
}
else {
    header("location: ../managecities.php");

    exit();
}
