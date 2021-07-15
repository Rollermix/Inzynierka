<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Praca inżynierska-logowanie</title>
</head>
<body>
<?php
require_once 'header.php';
require_once 'includes/dbh.inc.php';
?>
<form action="includes/adddog.inc.php" method="post" enctype="multipart/form-data">
    <input type = "text" name="name" placeholder="Jak się wabi twój pies">
    <select name ='size'>
        <option>Wybierz rozmiar psa...</option>
        <option>Mały</option>
        <option>Średni</option>
        <option>Duży</option>
    </select>
    <input type = "text" name="opis" placeholder="Opisz Twojego psa">
    <input type="file" name="file" >
    <button type = "submit" name ="submit">Wyślij</button>
</form>


</br>
</body>
</html>