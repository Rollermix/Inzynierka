<?php
session_start();
require_once 'dbh.inc.php';
require_once 'adminfunctions.inc.php';
    $description = $_POST["description"];
    $adminid =  $_SESSION["userid"];
    $id =  $_SESSION["reported"];
    sendReminder($conn,$adminid,$id,$description);

