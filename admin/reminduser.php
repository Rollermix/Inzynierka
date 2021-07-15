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
<section class="city-form">
    <h2>
        Zarządzaj użytkownikami
    </h2>
    <?php
    $_SESSION["reported"] = $_GET["iduser"];
    ?>
        <form action="includes/reminduser.inc.php" method="post">
        <input type = "text" name="description" placeholder="Dodaj krótki opis...">
        <button type = "submit" name ="submit"><a href="includes/reminduser.inc.php">Wyślij upomnienie</a></button>

        </form>


</section>

</body>
</html>