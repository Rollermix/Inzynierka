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
        echo '<button>'.'<a href="editwalk.php?id='.$row['id'].'">'.'Edytuj'.'</a>'.'</button>';
    }
}
?>
<br>
<?php
$sqli = 'SELECT walk.*,spot.name,user.login From walk INNER JOIN spot ON spot.id=walk.id_spot 
        INNER JOIN user ON user.id=walk.id_accompanied_user  WHERE walk.id_accompanied_user IS NOT NULL 
        AND walk.id_user="'.$_SESSION['userid'].'"';
$result = mysqli_query($conn, $sqli);
while ($row = mysqli_fetch_array($result)) {
        if($row['approved']==1) {
            echo "Twoje zatwierdzone spacery:<br>";
            echo 'Użytkownik: ' . $row['login'] . ' Miejsce ' . $row['name'] . ' Kiedy: ' . $row['time'] . ' Opis: ' . $row['description'];
            echo '<button>'.'<a href ="chat.php?id='.$row['id'].'">'.'Otwórz czat'.'</a>'.'</button>';
        }
        echo '<br>';
        echo "Twoje spacery do akceptacji:<br>";
        if($row['approved']==0 && $row['cancelled']==0) {
            echo 'Użytkownik: ' . $row['login'] . ' Miejsce ' . $row['name'] . ' Kiedy: ' . $row['time'] . ' Opis: ' .
                $row['description'].'<button>'.'<a href="includes/accept.inc.php?id='.$row['id'].'">'.'Akceptuj'.'</a>'.
                '</button>'.'<button>'.'<a href="includes/deny.inc.php?id='.$row['id'].'">'.'Anuluj'.'</a>'.'</button>';
        }
         if($row['cancelled']==1) {
        echo "Twoje anulowane spacery:<br>";
        echo 'Użytkownik: ' . $row['login'] . ' Miejsce ' . $row['name'] . ' Kiedy: ' . $row['time'] . ' Opis: ' . $row['description'];
    }
}
$sql2 = 'SELECT walk.*,spot.name,user.login From walk INNER JOIN spot ON spot.id=walk.id_spot 
        INNER JOIN user ON user.id=walk.id_user  WHERE walk.id_accompanied_user IS NOT NULL 
        AND walk.id_accompanied_user="'.$_SESSION['userid'].'"';
$result2 = mysqli_query($conn, $sql2);
$numrows2=mysqli_num_rows($result2);
if ($numrows2>0) {
    while ($row = mysqli_fetch_array($result2)) {
        echo 'Użytkownik: ' . $row['login'] . ' Miejsce ' . $row['name'] . ' Kiedy: ' . $row['time'] . ' Opis: ' . $row['description'];
    }
}

?>
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