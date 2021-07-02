<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Praca inżynierska-logowanie</title>
</head>
<body>
<?php
require_once 'adminheader.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/adminfunctions.inc.php';
isLogged();
?>

    <h2>
        Zarządzaj miejscami
    </h2>
<form action="includes/addspot.inc.php" method="post">
    <form method ="POST">
        <select name ='city'>
            <option>Wybierz miasto...</option>
            <?php
            $sqli = "SELECT name FROM city";
            $result = mysqli_query($conn, $sqli);
            while ($row = mysqli_fetch_array($result)) {

                echo '<option>'.$row['name'].'</option>';
            }
            ?>
        </select>
        <input type = "text" name="name" placeholder="Wpisz nazwę miejsca">
        <input type = "text" name="description" placeholder="Dodaj krótki opis...">
        <button type = "submit" name ="submit">Dodaj spot</button>
    </form>
</body>
</html>