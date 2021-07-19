<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Praca inżynierska-logowanie</title>
</head>
<body>
<?php
require_once 'adminheader.php';
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>

<?php
$sqli = "SELECT user.login,u.login AS `log`, notification.*, status.status From notification INNER JOIN status 
    ON notification.id_status = status.id INNER JOIN user ON user.id=notification.id_user INNER JOIN user AS `u` ON u.id=notification.id_reported_user
    ORDER BY notification.id_status ASC";
$result = mysqli_query($conn, $sqli);

if(mysqli_num_rows($result)>0)
{
    echo '<table>'.'<tr>'.'<th>Kto zgłasza</th>'.'<th>Kto jest zgłaszany</th>'.'<th>Powód</th>'.'<th>Status</th>'.'</tr>';
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>'.'<td>'.$row['login'].'</td>'.'<td>'.$row['log'].'</td>'.'<td>'.$row['reason'].'</td>'.'<td>'.$row['id_status'].'</td>'.'</tr>';
        echo '</table>';
    }
}
?>
</body>