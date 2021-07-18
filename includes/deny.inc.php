<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
if(isset($_GET["id"]))
{
    $idwalk=($_GET["id"]);
    $idcancellinguser = $_SESSION['userid'];
    echo $idcancellinguser;
    denyWalk($conn,$idwalk);
    cancellMessage($conn,$idwalk,$idcancellinguser);
}