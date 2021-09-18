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
        header("location: ". baseUrl() ."/views/contents/changepassword.php?error=emptyinput");
        exit();
    }
    if(pwdMatch($newpassword,$repeatnewpassword))
    {
        header("location: ". baseUrl() ."/views/contents/changepassword.php?error=passworddontmatch");
        exit();
    }
    $curr_pass = $_POST["password"];
    if($user_row = loginExists($conn, $_SESSION['useruid'], $_SESSION['useruid'])) {
        $password = $user_row['password'];
        if(!password_verify($curr_pass, $password)) {
            header("location: ". baseUrl() ."/views/contents/changepassword.php?error=wrongpassword");
            exit();
        }
    }
    editPwd($conn,$login,$password,$newpassword,$repeatnewpassword);
}