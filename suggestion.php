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
<form action="includes/suggestion.inc.php" method="post">
    <input type = "text" name="name" placeholder="Co chciałbyś, aby znalazło się w naszym systemie....">
    <button type = "submit" name ="submit">Wyślij</button>
</form>
</br>

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
</body>
</html>