<?php
session_start();
if(isset($_POST["submit2"])) {
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    $password = $_POST["password"];
    $newpassword = $_POST["newpassword"];
    $repeatnewpassword = $_POST["repeatnewpassword"];
    $login=$_SESSION["useruid"];

    if (emptyInputChangingPwd($password, $newpassword, $repeatnewpassword) !== false) {
        header("location: ../manageaccount.php?error=emptyinput");
        exit();
    }
    if(pwdMatch($newpassword,$repeatnewpassword)!==false)
    {
        header("location: ../manageaccount.php?error=passworddontmatch");
        exit();
    }
    editPwd($conn,$login,$password,$newpassword,$repeatnewpassword);
}