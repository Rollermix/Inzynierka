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
<?php
$sql2 = 'SELECT id_city From USER WHERE id="'.$_SESSION['userid'].'"';
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($result2);
$mycity = $row2['id_city'];

echo "Znaleziono następujące spacery:<br>";
$sqli = 'SELECT walk.*,spot.name,user.login,user.id_city From walk INNER JOIN spot ON spot.id=walk.id_spot INNER JOIN user ON user.id=walk.id_user 
        WHERE walk.id_accompanied_user IS NULL AND walk.id_user!="'.$_SESSION['userid'].'" AND user.id_city ="'.$mycity.'"';
$result = mysqli_query($conn, $sqli);
while ($row = mysqli_fetch_array($result)) {
    if ($row['id_accompanied_user'] == NULL) {
        echo 'Dodał '.$row['login'].'Miejsce '.$row['name'].' Kiedy: '.$row['time'].' Opis: '.$row['description'].
            '<button><a href="includes/acceptwalk.inc.php?id_walk='.$row['id'].'">Akceptuj</a></button>';
    }
}


?>


</br>
</body>
</html>