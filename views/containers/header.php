<?php 
session_start();
if(file_exists(stream_resolve_include_path('../../includes/functions.inc.php'))) {
    require_once('../../includes/functions.inc.php');
    require_once('../../includes/dbh.inc.php');
}
if(file_exists(stream_resolve_include_path('../includes/dbh.inc.php'))) {
    require_once('../includes/functions.inc.php');
    require_once('../includes/dbh.inc.php');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <?php
        if(isset($_SESSION["userid"]) && $messagesCount = hasUnreadMessages($conn, $_SESSION["userid"])) {
            echo "<title>DoggoWalks (".$messagesCount.")</title>";
        } else {
            echo "<title>DoggoWalks</title>";
        }
    ?>
    <?php
        if(file_exists(stream_resolve_include_path('../../includes/functions.inc.php'))) {
            echo '<link rel="stylesheet" href="../../assets/css/normalize.css">';
            echo '<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">';
            echo '<link rel="stylesheet" href="../../assets/css/webfont.css">';    
            echo '<link rel="stylesheet" href="../../assets/css/main.css">';
            echo '<link rel="icon" type="image/png" href="../../assets/img/favicon.png">';
        } else {
            echo '<link rel="stylesheet" href="../assets/css/normalize.css">';
            echo '<link rel="stylesheet" href="../assets/css/bootstrap.min.css">';
            echo '<link rel="stylesheet" href="../assets/css/webfont.css">';    
            echo '<link rel="stylesheet" href="../assets/css/main.css">';
            echo '<link rel="icon" type="image/png" href="../assets/img/favicon.png">';
        }
    ?>
</head>
<body>