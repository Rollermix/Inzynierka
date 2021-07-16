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
echo "Znaleziono następujące spacery:<br>";
$sqli = 'SELECT walk.*,spot.name,user.login From walk INNER JOIN spot ON spot.id=walk.id_spot INNER JOIN user ON user.id=walk.id_user 
        WHERE walk.id_accompanied_user IS NULL AND id_user!="'.$_SESSION['userid'].'"';
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