<?php
session_start();
require_once 'dbh.inc.php';
require_once 'adminfunctions.inc.php';
if(isset($_POST["submit"]))
{
    $check='Wybierz województwo...';
    $voivodshipid = $_POST["voivodship"];
    $name = $_POST['name'];
    $description = $_POST['description'];

    if ($voivodshipid === $check)
    {
        header("location: ../managecities.php?error=errorinputvoivodship");
        exit();
    }
    if(emptyInputAdd($name)!==false)
    {
        header("location: ../managecities.php?error=emptyinputcity");
        exit();
    }
    addcity($conn,$voivodshipid,$name,$description);
}
else if(isset($_GET["delete"])) {
    $nazwa = ($_GET["delete"]);
    {
        deleteCity($conn,$nazwa);
    }
}
else
{
    header("location: ../managecities.php");
    exit();
}