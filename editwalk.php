<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Praca inżynierska-logowanie</title>
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<?php
require_once 'header.php';
require_once 'includes/dbh.inc.php';
?>
<?php
$idwalk = $_GET["id"];
echo '<form action="includes/editwalk.inc.php?id='.$idwalk.'" method="post">';
?>
    <select name ='spot'>
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
    <input type="datetime-local" name="date">
    <input type="text" name="description" placeholder="Opis...">
    <button type = "submit" name ="submit">Edytuj spacer</button>

</form>


</br>
</body>
<?php require_once 'footer.php'; ?>
</html>