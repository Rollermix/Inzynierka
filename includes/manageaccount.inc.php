<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$login = $_POST["login"];
$email = $_POST["email"];
$description = $_POST["description"];
$city = $_POST["city"];
$id = $_SESSION["idchanging"];

if(!empty($login))
{
    if(invalidLogin($login)!==false)
    {
        header("location: ../manageaccount?error=invalidlogin");
        exit();
    }
}
else
    $login=NULL;

if(!empty($email)) {
    if (invalidEmail($email) !== false) {
        header("location: ../manageaccount?error=invalidemail");
        exit();
    }
}
else
    $email=NULL;
if(!empty($newpassword)|| !empty($repeatnewpassword)) {
    if (pwdMatch($newpassword, $repeatnewpassword) !== false) {
        header("location: ../manageaccount?error=passworddontmatch");
        exit();
    }
}
if(!empty($login)) {
    if (loginExists($conn, $login, $email) !== false) {
        header("location: ../manageaccount.php?error=logintaken");
        exit();
    }
}

editUser($conn,$firstname,$lastname,$login,$email,$description,$newpassword,$city,$id,$password);