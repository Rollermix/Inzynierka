<?php
session_start();
if(isset($_POST["submit"])) {
    $suggestion = $_POST["name"];
    $iduser = $_SESSION["userid"];
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    if(emptyInputSuggestion($suggestion)!==false)

    {
        header("location: ". baseUrl() ."/views/contents/suggestion.php?error=emptyinput");
        exit();
    }
    if(toLongSuggestion($suggestion)!==false)
    {
        header("location: ". baseUrl() ."/views/contents/suggestion.php?error=tolongsuggestion");
        exit();
    }
    addSuggestion($conn,$suggestion,$iduser);
}