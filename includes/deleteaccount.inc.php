<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if(!isset($_POST["password_delete_account"])) {
    // redirect
}

if(isset($_GET["id"])) {
    $id = ($_GET["id"]);
    $curr_pass = $_POST["password_delete_account"];
    if($user_row = loginExists($conn, $_SESSION['useruid'], $_SESSION['useruid'])) {
       $password = $user_row['password'];
       if(password_verify($curr_pass, $password)) {
           deleteAccount($conn, $id);
       } else {
           echo "Niepoprawne hasło, konto nie zostanie usunięte";
       }
    }
}
