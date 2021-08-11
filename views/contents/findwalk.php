<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>

<?php
$sql2 = 'SELECT id_city From USER WHERE id="'.$_SESSION['userid'].'"';
$result2 = mysqli_query($conn, $sql2);
$row2 = mysqli_fetch_array($result2);
$mycity = $row2['id_city'];

echo "Znaleziono następujące spacery:<br>";
$sqli = 'SELECT walk.*,spot.name,user.login,user.id_city,dog.name AS dogname,dog.size
    From walk 
    INNER JOIN spot ON spot.id=walk.id_spot 
    INNER JOIN user ON user.id=walk.id_user 
    INNER JOIN dog ON dog.id_user=user.id
WHERE walk.id_accompanied_user IS NULL AND walk.id_user!="'.$_SESSION['userid'].'" AND user.id_city ="'.$mycity.'"';
$result = mysqli_query($conn, $sqli);
if(mysqli_num_rows($result)>0) {
echo '<table>'.'<tr>'.'<th>Dodał</th>'.'<th>Miejsce</th>'.'<th>Kiedy</th>'.'<th>Opis</th>'.'<th>Rozmiar psa</th>'.'<th>Jak sie wabi pies</th>'.'<th></th></tr>';
while ($row = mysqli_fetch_array($result)) {
    if ($row['id_accompanied_user'] == NULL) {

      echo '<tr><td>'.'<a href="'.baseUrl().'/views/contents/profile.php?login='.$row['login'].'">'.$row['login'].'</a>'.'</td><td>'. $row['name'] . '</td><td> ' . $row['time'] . '</td><td>' . $row['description'].
          '</td><td>'.$row['size'].'</td><td>'.$row['dogname'].'</td><td>'.
            '<a class="btn btn-success" href="' . baseUrl() . '/includes/acceptwalk.inc.php?id_walk=' . $row['id'] . '">Akceptuj</a>'.'</td></tr>';
    }
    echo '</table>';
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
    echo ' <form action="'. baseUrl() .'/includes/reportuser.inc.php" method="post">';
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
    echo "Nie możesz zgłaszać uzytkowników";
}
?>
<?php require_once '../containers/footer.php'; ?>
