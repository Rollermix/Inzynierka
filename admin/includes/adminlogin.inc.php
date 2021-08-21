<?php
session_start();
if(isset($_POST["submit"]))
{
    $login = $_POST["name"];
    $password = $_POST["password"];
    require_once 'dbh.inc.php';
    require_once 'adminfunctions.inc.php';

    if(emptyInputLogin($login,$password)!==false)
    {
        header("location: ../login.php?error=emptyinput");
        exit();
    }
    loginAdminUser($conn,$login,$password);
}
else
{
    header("location: ../login.php");
    exit();
}
