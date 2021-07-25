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
<?php
$id = $_SESSION["userid"];
$sql2 = "SELECT blocked From user WHERE id ='".$id."'";
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($result2);
if ($row2['blocked']==0) {
    echo '<a>Zgłoś użytkownika</a>';
    echo ' <form action="includes/reportuser.inc.php" method="post">';
    echo ' <select name ="user">';
    echo ' <option>Wybierz Użytkownika</option>';
    $sqli = 'SELECT walk.id_user,user.login FROM walk INNER JOIN user ON walk.id_user=user.id WHERE user.login !="' . $_SESSION['useruid'] . '"';
    $result = mysqli_query($conn, $sqli);
    while ($row = mysqli_fetch_array($result)) {

        echo '<option>' . $row['login'] . '</option>';
    }

    echo '</select>';
    echo '<input type = "text" name="reason" placeholder="Wpisz powód zgłoszenia">';
    echo '<button type = "submit" name ="submit">Wyślij zgłoszenie</button>';
    echo '</form>';
}
else if ($row2['blocked']==2)
{
    echo "Nie zgłaszać uzytkowników";
}
?>


</body>
<?php require_once 'footer.php'; ?>
</html>