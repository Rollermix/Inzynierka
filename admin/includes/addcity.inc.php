<?php
if(isset($_POST["submit"]))
{
    $check='Wybierz województwo...';
    $voivodshipid = $_POST["voivodship"];
    $name = $_POST['name'];
    $description = $_POST['description'];
    require_once 'dbh.inc.php';
    require_once 'adminfunctions.inc.php';
    if ($voivodshipid === $check)
    {
        header("location: ../managecities.php?error=errorinputvoivodship");
        exit();
    }
    if(emptyInputAddCity($name)!==false)
    {
        header("location: ../managecities.php?error=emptyinputcity");
        exit();
    }
    addcity($conn,$voivodshipid,$name,$description);
}
else
{
    header("location: ../managecities.php");
    exit();
}