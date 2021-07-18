<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
session_start();
if (isset($_POST["submit"]))
{
    $message = $_POST["message"];
    $idwalk = $_GET["id"];
    $idsendinguser = $_SESSION['userid'];
    sendMessage($conn,$idwalk,$idsendinguser,$message);
}

