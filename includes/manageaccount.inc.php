<?php
session_start();
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

if(!empty($login)) {
    if (loginExists($conn, $login, $email) !== false) {
        header("location: ../manageaccount.php?error=logintaken");
        exit();
    }
}
if(empty($firstname))
    $firstname=NULL;
if(empty($lastname))
    $lastname=NULL;
if(empty($description))
    $description=NULL;
if(empty($city))
    $city=NULL;

editUser($conn,$firstname,$lastname,$login,$email,$description,$city,$id);