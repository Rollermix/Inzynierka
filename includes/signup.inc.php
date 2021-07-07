<?php
if (isset($_POST["submit"]))
{
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $login = $_POST["login"];
    $email = $_POST["email"];
    $description = $_POST["description"];
    $password = $_POST["password"];
    $repeatpassword = $_POST["repeatpassword"];
    $city = $_POST["city"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    if(emptyInputSignup($firstname,$lastname,$login,$email,$password,$repeatpassword)!==false)
    {
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if(invalidLogin($login)!==false)
    {
        header("location: ../signup.php?error=invalidlogin");
        exit();
    }
    if(invalidEmail($email)!==false)
    {
        header("location: ../signup.php?error=invalidemail");
        exit();
    }
    if(pwdMatch($password,$repeatpassword)!==false)
    {
        header("location: ../signup.php?error=passworddontmatch");
        exit();
    }
    if(loginExists($conn,$login,$email)!==false)
    {
        header("location: ../signup.php?error=logintaken");
        exit();
    }
    createUser($conn,$firstname,$lastname,$login,$email,$description,$password,$city);

}
else
{
    header("location: ../signup.php");
}
