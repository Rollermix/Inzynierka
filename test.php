<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<?php
require_once 'includes/dbh.inc.php';
?>
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


    <input type="submit" name="Submit" value="Send">

</form>
<?php
if(isset($_POST['voivodship'])) {
    if($_POST['voivodship']!=="Wybierz województwo...")
    echo "selected voivodship: ".htmlspecialchars($_POST['voivodship']);
    else
        echo "nie wybrałeś województwa";
}
?>

</body>
</html>