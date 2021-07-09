<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
if(isset($_GET["id"])) {
    $id = ($_GET["id"]);
    {
        deleteAccount($conn, $id);
    }
}
