<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<?php
canViewAsAdmin($conn);
?>
<div class="container custom-menu">
    <ul class="nav nav-tabs custom-tabs">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="suggestions.php" role="tab">Zarządzaj sugestiami</a>
        </li>
        <li class="nav-item active" role="presentation">
            <a class="nav-link active" href="managenotification.php" data-toggle="tab" role="tab" aria-selected="true">Zarządzaj zgłoszeniami</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="managecities.php" role="tab">Zarządzaj miastami</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="manageusers.php" role="tab">Zarządzaj użytkownikami</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="managespots.php" role="tab">Zarządzaj miejscami</a>
        </li>
    </ul>
    <h2 class="h2 text-center">
        Zgłoszenia
    </h2>
    <br>
<?php
$sqli = "SELECT user.login,u.login AS `log`, notification.*, status.id AS `statusid`,status.status From notification INNER JOIN status 
    ON notification.id_status = status.id INNER JOIN user ON user.id=notification.id_user INNER JOIN user AS `u` ON u.id=notification.id_reported_user
    ORDER BY notification.id_status ASC";
$result = mysqli_query($conn, $sqli);

if(mysqli_num_rows($result)>0)
{

    echo '<table class="table table-hover"><thead>'.'<tr class="bg-dark">'.'<th>Kto zgłasza</th>'.'<th>Kto jest zgłaszany</th>'.'<th>Powód</th>'.'<th>Status</th><th>Akcje</th>'.'</tr></thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_array($result)) {
        if($row['statusid']==1)
        {
            echo '<tr>' . '<td>' . $row['login'] . '</td>' . '<td>' . $row['log'] . '</td>' . '<td>' . $row['reason'] .
                '</td>' . '<td>' . $row['status'] . '</td>' .'<td class="d-flex justify-content-between">'.
                '<a class="btn btn-dark" href="includes/managenotification.inc.php?accept='.$row['id'].'&iduser='.$row['id_reported_user']. '">'.
                'Akceptuj'.'</a>'.'<a class="btn btn-dark" href="includes/managenotification.inc.php?deny='.$row['id'].'">'.
                'Odrzuć'.'</a>'.'</td>' .'</tr>';
            readNotofication($conn,$row["id"]);
        }
        else  if ($row['statusid']==2)
        {
        echo '<tr>' . '<td>' . $row['login'] . '</td>' . '<td>' . $row['log'] . '</td>' . '<td>' . $row['reason'] .
            '</td>' . '<td>' . $row['status'] . '</td>' .'<td class="d-flex justify-content-between">'.
            '<a class="btn btn-dark" href="includes/managenotification.inc.php?accept='.$row['id'].'&iduser='.$row['id_reported_user']. '">'.
            'Akceptuj'.'</a>'.'<a class="btn btn-dark" href="includes/managenotification.inc.php?deny='.$row['id'].'">'.
            'Odrzuć'.'</a>'.'</td>' .'</tr>';

        }
        else if ($row['statusid']==3)
        {
            echo '<tr>' . '<td>' . $row['login'] . '</td>' . '<td>' . $row['log'] . '</td>' . '<td>' . $row['reason'] .
                '</td>' . '<td>' . $row['status'] . '</td>' . '<td></td></tr>';
        }
        else if ($row['statusid']==4)
        {
            echo '<tr>' . '<td>' . $row['login'] . '</td>' . '<td>' . $row['log'] . '</td>' . '<td>' . $row['reason'] .
                '</td>' . '<td>' . $row['status'] . '</td>' . '<td>'.'<a style="white-space: unset" class="btn btn-dark" href="reminduser.php?iduser='.$row["id_user"].'">'.
                'Upomnij użytkownika, którzy zgłaszał'.'</a>'.'</>'.'</td>'.'</tr>';
        }
    }
    echo '</tbody>';
    echo '</table>';

}
?>
</div>
<?php require_once '../views/containers/footer.php'; ?>