<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if(isset($_POST["submit"])) {
    $option= "Wybierz miejsce";
    $spot = $_POST["spot"];
    $date = date('Y-m-d H:i:s',strtotime($_POST["date"]));
    $description = $_POST["description"];
    if (empty($description))
        $description="Nie dodano opisu";
    if($spot === $option)
    {
        header("location: " . baseUrl() . "/views/contents/addwalk.php?error=emptyinput");
        exit();
    }
    $addinguser= $_SESSION["userid"];
    addwalk($conn, $spot, $date,$description,$addinguser);
    exit();
}