<?php
if(isset($_POST["submit"]))
{
    $login = $_POST["name"];
    $password = $_POST["password"];
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(emptyInputLogin($login,$password)!==false)
    {
        header("location: ".baseUrl()."/views/contents/login.php?error=emptyinput");
        exit();
    }
    if(isBlocked($conn,$login)!==false)
    {
        header("location: ".baseUrl()."/views/contents/login.php?error=accountblocked");
        exit();
    }
    if(isDeleted($conn,$login)!==false)
    {
        header("location: ".baseUrl()."/views/contents/login.php?error=accountdeleted");
        exit();
    }
    loginUser($conn,$login,$password);
}
else if ((isset($_POST["submit2"])))
{
    $login = $_POST["name"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    if(empty($login))
    {
        header("location: ".baseUrl()."/views/contents/login.php?error=emptylogin");
        exit();
    }
    if(loginExists2($conn,$login)!==true)
    {
        header("location: ".baseUrl()."/views/contents/login.php?error=loginnotexist");
        exit();
    }
    remindPassword($conn,$login);
}
else
{
    header("location: ".baseUrl()."/views/contents/login.php");
    exit();
}
