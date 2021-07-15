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
<form action="includes/adddog.inc.php" method="post">
    <select name ='id_spot'>
        <option>Wybierz miejsce</option>
        <?php
        $sqli = "SELECT spot.name FROM spot INNER JOIN city ON spot.id_city=city.id WHERE city.id=(SELECT id_city FROM user WHERE id=".$_SESSION["userid"].")";
        $result = mysqli_query($conn, $sqli);
        while ($row = mysqli_fetch_array($result)) {
            if($row['deleted']==0)
                echo '<option>'.$row['name'].'</option>';

        }
        ?>
    </select>

</form>


</br>
</body>
</html>