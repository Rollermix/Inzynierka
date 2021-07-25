<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php
$id = $_SESSION["userid"];
$sqli = "SELECT blocked From user WHERE id ='".$id."'";
$result = mysqli_query($conn, $sqli);
$row = mysqli_fetch_array($result);
if ($row['blocked']==0) {
    echo '<form action="'.baseUrl().'/includes/suggestion.inc.php" method="post">';
    echo '<input type = "text" name="name" placeholder="Co chciałbyś, aby znalazło się w naszym systemie....">';
    echo '<button type = "submit" name ="submit">Wyślij</button>';
    echo '</form>';
    echo '</br>';
}
else if ($row['blocked']==2)
{
    echo "Nie możesz wysyłać sugestii";
}
?>
<?php
$id = $_SESSION["userid"];
$sqli = "SELECT suggestions.id_status,suggestions.suggestion, status.status From suggestions INNER JOIN status 
    ON suggestions.id_status = status.id WHERE id_user ='".$id."'";
$result = mysqli_query($conn, $sqli);

if(mysqli_num_rows($result)>0)
{
    echo '<table>'.'<tr>'.'<th>Nazwa</th>'.'<th>Status</th>'.'</tr>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr><td>'.$row['suggestion'].'</td>' .'<td>'. $row['status'] .'</td>' .'</tr>';
        echo '</table>';
    }
}
else
    echo "nie zgłaszałeś nam nic!";
?>
<?php require_once '../containers/footer.php'; ?>
