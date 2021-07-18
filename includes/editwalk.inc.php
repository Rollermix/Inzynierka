<?php
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
if(isset($_POST["submit"])) {
    $spot = $_POST["spot"];
    $validation='1970-01-01 01:00:00';
    $validationdate = date('Y-m-d H:i:s',strtotime($validation));
    $date = date('Y-m-d H:i:s',strtotime($_POST["date"]));
    $description = $_POST["description"];
    $idwalk=$_GET['id'];
    if (empty($description))
        $description=NULL;
    if ($validationdate==$date);
        $date=NULL;
    if($spot=="Wybierz Miejsce")
        $spot=NULL;
    editWalk($conn,$idwalk,$spot,$date,$description);
}
