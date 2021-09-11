<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<div class="container admin-menu">
    <ul class="nav nav-tabs admin-tabs">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="suggestions.php" role="tab">Zarządzaj sugestiami</a>
        </li>
        <li class="nav-item active" role="presentation">
            <a class="nav-link active" href="managenotification.php" data-toggle="tab" role="tab" aria-selected="true">Zarządzaj zgłoszeniami</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="managecities.php" role="tab">Dodaj miasto</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="manageusers.php" role="tab">Zarządzaj użytkownikami</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="managespots.php" role="tab">Zarządzaj miejscami</a>
        </li>
    </ul>
<?php
$sqli = "SELECT user.login,u.login AS `log`, notification.*, status.id AS `statusid`,status.status From notification INNER JOIN status 
    ON notification.id_status = status.id INNER JOIN user ON user.id=notification.id_user INNER JOIN user AS `u` ON u.id=notification.id_reported_user
    ORDER BY notification.id_status ASC";
$result = mysqli_query($conn, $sqli);

if(mysqli_num_rows($result)>0)
{

    echo '<table class="table table-hover"><thead>'.'<tr>'.'<th>Kto zgłasza</th>'.'<th>Kto jest zgłaszany</th>'.'<th>Powód</th>'.'<th>Status</th>'.'</tr></thead>';
    echo '<tbody>';
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
                '</td>' . '<td>' . $row['status'] . '</td>' . '<td></td></tr>';
        }
        else if ($row['statusid']==4)
        {
            echo '<tr>' . '<td>' . $row['login'] . '</td>' . '<td>' . $row['log'] . '</td>' . '<td>' . $row['reason'] .
                '</td>' . '<td>' . $row['status'] . '</td>' . '<td>'.'<button>'.'<a href="reminduser.php?iduser='.$row["id_user"].'">'.
                'Upomnij użytkownika, którzy zgłaszał'.'</a>'.'</button>'.'</td>'.'</tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';

}
?>
</div>
<?php require_once '../views/containers/footer.php'; ?>