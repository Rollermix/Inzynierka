<?php

session_start();
require_once 'adminfunctions.inc.php';
require_once 'dbh.inc.php';
if (isset($_GET["discard"])) {


    $id = ($_GET["discard"]);
    {
        discardSuggestion($conn, $id);
    }
}