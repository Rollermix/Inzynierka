<?php
session_start();
require_once 'adminfunctions.inc.php';
require_once 'dbh.inc.php';
isLogged();
if(isset($_GET["block"])) {


    $nazwa = ($_GET["block"]);
    {
        blockUser($conn,$nazwa);
    }
}
if(isset($_GET["unblock"])) {


    $nazwa = ($_GET["unblock"]);
    {
        unblockUser($conn,$nazwa);
    }
}
if(isset($_GET["delete"])) {


    $nazwa = ($_GET["delete"]);
    {
        deleteUser($conn,$nazwa);
    }
}
if(isset($_GET["reporting"]))
{
    $nazwa = $_GET["reporting"];
    blockreporting($conn,$nazwa);
}
if(isset($_GET["unblockreporting"]))
{
    $nazwa = $_GET["unblockreporting"];
    unblockreporting($conn,$nazwa);
}


