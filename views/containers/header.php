<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>DoggoWalks - praca inżynierska</title>
    <?php 
        if(file_exists(stream_resolve_include_path('../../includes/functions.inc.php'))) {
            echo '<link rel="stylesheet" href="../../assets/css/normalize.css">';
            echo '<link rel="stylesheet" href="../../assets/css/bootstrap.min.css">';
            echo '<link rel="stylesheet" href="../../assets/css/webfont.css">';    
            echo '<link rel="stylesheet" href="../../assets/css/main.css">';
        } else {
            echo '<link rel="stylesheet" href="../assets/css/normalize.css">';
            echo '<link rel="stylesheet" href="../assets/css/bootstrap.min.css">';
            echo '<link rel="stylesheet" href="../assets/css/webfont.css">';    
            echo '<link rel="stylesheet" href="../assets/css/main.css">';
        }
    ?>
</head>
<body>
<?php

if(file_exists(stream_resolve_include_path('../../includes/functions.inc.php'))) {
    require_once('../../includes/functions.inc.php');
    require_once('../../includes/dbh.inc.php');
}
if(file_exists(stream_resolve_include_path('../includes/dbh.inc.php'))) {
    require_once('../includes/functions.inc.php');
    require_once('../includes/dbh.inc.php');
}

?>