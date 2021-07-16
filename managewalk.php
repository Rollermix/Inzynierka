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
<a href ="addwalk.php">Dodaj spacer</a>
<a href ="findwalk.php">Znajdź spacer</a>
<br>
<?php
echo "Twoje spacery bez par:<br>";
$sqli = 'SELECT walk.*,spot.name From walk INNER JOIN spot ON spot.id=walk.id_spot WHERE walk.id_user="'.$_SESSION['userid'].'"';
$result = mysqli_query($conn, $sqli);
while ($row = mysqli_fetch_array($result)) {
    if ($row['id_accompanied_user'] == NULL) {
        echo 'Miejsce '.$row['name'].' Kiedy: '.$row['time'].' Opis: '.$row['description'];
    }
}


?>
<br>
<?php
echo "Twoje zaakceptowane spacery:<br>";
$sqli = 'SELECT walk.*,spot.name,user.login From walk INNER JOIN spot ON spot.id=walk.id_spot 
        INNER JOIN user ON user.id=walk.id_accompanied_user  WHERE walk.id_accompanied_user IS NOT NULL 
        AND walk.id_user="'.$_SESSION['userid'].'"OR walk.id_accompanied_user="'.$_SESSION['userid'].'"';
$result = mysqli_query($conn, $sqli);
while ($row = mysqli_fetch_array($result)) {
        echo 'Użytkownik: '.$row['login'].' Miejsce '.$row['name'].' Kiedy: '.$row['time'].' Opis: '.$row['description'];
}


?>

</br>
</body>
</html>