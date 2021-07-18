<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
if(isset($_POST["submit"])) {

    $reason = $_POST["reason"];
    $user = $_SESSION["userid"];
    $reporteduser=$_POST['user'];
    if(emptyField($reason)!==false)
    {
        header("location: ../managewalk.php?error=emptyinputReason");
        exit();
    }
    if($reporteduser="Wybierz Użytkownika")
    {
        header("location: ../managewalk.php?error=emptyinputUser");
        exit();
    }
    reportUser($conn,$reason,$user,$reporteduser);
}