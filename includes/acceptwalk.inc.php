<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
if(isset($_GET["id_walk"]))
{
    $idwalk=($_GET["id_walk"]);
    $iduser=($_SESSION['userid']);
    acceptWalk($conn,$iduser,$idwalk);
}