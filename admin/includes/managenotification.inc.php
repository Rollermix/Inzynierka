<?php
require_once 'adminfunctions.inc.php';
require_once 'dbh.inc.php';
if(isset($_GET["accept"]))
{
    $id=$_GET["accept"];
    $iduser=$_GET['iduser'];
    acceptnotification($conn,$id,$iduser);

}
else if(isset($_GET["deny"]))
{
    $id=$_GET["deny"];
    denynotification($conn,$id);
}
