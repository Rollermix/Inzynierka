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
$sqli = "SELECT user.login,u.login AS `log`, notification.*, status.id AS `statusid`,status.status From notification INNER JOIN status 
    ON notification.id_status = status.id INNER JOIN user ON user.id=notification.id_user INNER JOIN user AS `u` ON u.id=notification.id_reported_user
    ORDER BY notification.id_status ASC";
$result = mysqli_query($conn, $sqli);

if(mysqli_num_rows($result)>0)
{

    echo '<table>'.'<tr>'.'<th>Kto zgłasza</th>'.'<th>Kto jest zgłaszany</th>'.'<th>Powód</th>'.'<th>Status</th>'.'</tr>';
    while ($row = mysqli_fetch_array($result)) {
        if($row['statusid']==1)
        {
            echo '<tr>' . '<td>' . $row['login'] . '</td>' . '<td>' . $row['log'] . '</td>' . '<td>' . $row['reason'] .
                '</td>' . '<td>' . $row['status'] . '</td>' .'<td>'.'<button>'.
                '<a href="includes/managenotification.inc.php?accept='.$row['id'].'&iduser='.$row['id_reported_user']. '">'.
                'Akceptuj'.'</a>'.'</button>'.'<a href="includes/managenotification.inc.php?deny='.$row['id'].'">'.
                'Odrzuć'.'</a>'.'</button>'.'</td>' .'</tr>';
            readNotofication($conn,$row["id"]);
        }
        else  if ($row['statusid']==2)
        {
        echo '<tr>' . '<td>' . $row['login'] . '</td>' . '<td>' . $row['log'] . '</td>' . '<td>' . $row['reason'] .
            '</td>' . '<td>' . $row['status'] . '</td>' .'<td>'.'<button>'.
            '<a href="includes/managenotification.inc.php?accept='.$row['id'].'&iduser='.$row['id_reported_user']. '">'.
            'Akceptuj'.'</a>'.'</button>'.'<a href="includes/managenotification.inc.php?deny='.$row['id'].'">'.
            'Odrzuć'.'</a>'.'</button>'.'</td>' .'</tr>';

        }
        else if ($row['statusid']==3)
        {
            echo '<tr>' . '<td>' . $row['login'] . '</td>' . '<td>' . $row['log'] . '</td>' . '<td>' . $row['reason'] .
                '</td>' . '<td>' . $row['status'] . '</td>' . '</tr>';
        }
        else if ($row['statusid']==4)
        {
            echo '<tr>' . '<td>' . $row['login'] . '</td>' . '<td>' . $row['log'] . '</td>' . '<td>' . $row['reason'] .
                '</td>' . '<td>' . $row['status'] . '</td>' . '<td>'.'<button>'.'<a href="reminduser.php?iduser='.$row["id_user"].'">'.
                'Upomnij użytkownika, którzy zgłaszał'.'</a>'.'</button>'.'</td>'.'</tr>';
        }
        echo '</table>';
    }
}
?>
</body>