<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container custom-container">

<a class="btn btn-info" href =  "<?= baseUrl() . "/views/contents/addwalk.php"?>">Dodaj spacer</a>
<br>
<a class="btn btn-info" href = "<?= baseUrl() . "/views/contents/findwalk.php"?>">Znajdź spacer</a>
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
            echo '<a class="btn btn-info" href ="chat.php?id='.$row['id'].'">'.'Otwórz czat'.'</a>';
        }
        echo '<br>';
        echo "Twoje spacery do akceptacji:<br>";
        if($row['approved']==0 && $row['cancelled']==0) {
            echo 'Użytkownik: ' . $row['login'] . ' Miejsce ' . $row['name'] . ' Kiedy: ' . $row['time'] . ' Opis: ' .
                $row['description'].'<a class="btn btn-success" href="includes/accept.inc.php?id='.$row['id'].'">'.'Akceptuj'.'</a><br>'.
                '<a class="btn btn-danger" href="includes/deny.inc.php?id='.$row['id'].'">'.'Anuluj'.'</a>';
        }
         if($row['cancelled']==1) {
        echo "Twoje anulowane spacery:<br>";
        echo 'Użytkownik: ' . $row['login'] . ' Miejsce ' . $row['name'] . ' Kiedy: ' . $row['time'] . ' Opis: ' . $row['description'];
    }
}
$sql2 = 'SELECT walk.*,spot.name,user.login From walk INNER JOIN spot ON spot.id=walk.id_spot 
        INNER JOIN user ON user.id=walk.id_user  WHERE  walk.id_accompanied_user="'.$_SESSION['userid'].'"';
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

    echo ' <div class="form-group d-flex flex-column justify-content-center" id="manage-walks">';
    echo '<h3>Zgłoś użytkownika</h3>';
    echo '<br>';
    echo ' <form action="'.baseUrl().'/includes/reportuser.inc.php" method="post">';
    echo ' <select name ="user" class="custom-select">';
    echo ' <option>Wybierz Użytkownika</option>';
    $sqli = 'SELECT walk.id_user,user.login FROM walk INNER JOIN user ON walk.id_user=user.id WHERE user.login !="' . $_SESSION['useruid'] . '"';
    $result = mysqli_query($conn, $sqli);
    while ($row = mysqli_fetch_array($result)) {

        echo '<option value="'.$row['login'].'">' . $row['login'] . '</option>';
    }
}
?>

</select>
<br>
<br>

<textarea class="form-control" type = "text" name="reason" placeholder="Wpisz powód zgłoszenia"></textarea>
<button class="btn btn-info" type = "submit" name ="submit">Wyślij zgłoszenie</button>
</form>
</div>

<?php
if ($row2['blocked']==2)
{
    echo "Nie możesz zgłaszać uzytkowników";
}
?>
</div>

<?php require_once '../containers/footer.php'; ?>
