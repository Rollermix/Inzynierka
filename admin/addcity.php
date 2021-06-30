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
?>
<section class="city-form">
    <h2>
        Dodaj miasto
    </h2>
    <form action="includes/addcity.inc.php" method="post">
        <form method ="POST">
            <select name ='voivodship'>
                <option>Wybierz województwo...</option>
                <?php

                $sqli = "SELECT id,name FROM voivodship";
                $result = mysqli_query($conn, $sqli);
                while ($row = mysqli_fetch_array($result)) {
                    echo '<option>'.$row['id'].'.'.$row['name'].'</option>';
                }
                ?>
            </select>
        <input type = "text" name="name" placeholder="Wpisz nazwę miasta">
        <button type = "submit" name ="submit">Dodaj miasto</button>
    </form>
</section>

</body>
</html>
