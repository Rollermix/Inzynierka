<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>

<?php
$sqli = "SELECT suggestions.id AS 'id',suggestions.id_user AS 'iduser', suggestions.id_status,suggestions.suggestion, status.status From suggestions INNER JOIN status 
    ON suggestions.id_status = status.id ORDER BY suggestions.id_status ASC";
$result = mysqli_query($conn, $sqli);

if(mysqli_num_rows($result)>0)
{
    echo '<table>'.'<tr>'.'<th>Nazwa</th>'.'<th>Status</th>'.'</tr>';
    while ($row = mysqli_fetch_array($result)) {
        if($row['id_status']==1) {
            readSuggestion($row["id"],$conn);
        } if($row['id_status']==2) {
            echo '<tr><td>' . $row['suggestion'] . '</td>' . '<td>' . $row['status'] . '</td>' .'<td>'.
                '<button>'.'<a href="addcity.php?acceptcity='.$row["id"].'">'.'Dodaj miasto'.'</a>'.
                '</button>'.'</td>'.'<td>'.'<button>'.'<a href="managespots.php?acceptspot='.$row["id"].'">'.'Dodaj spot'.'</a>'.
                '</button>'.'</td>'.'<td>'.'<button>'.'<a href="includes/suggestions.inc.php?discard='.$row["id"].'">'.'Odrzuć'.'</a>'.
                '</button>'.'</td>'.'</tr>';
        }
        if($row['id_status']==3) {
            echo '<tr><td>' . $row['suggestion'] . '</td>' . '<td>' . $row['status'] . '</td>'.'</tr>';
        }if($row['id_status']==4) {
            echo '<tr><td>' . $row['suggestion'] . '</td>' . '<td>' . $row['status'] . '</td>'.
                '<td>'.'<button>'.'<a href="reminduser.php?iduser='.$row["iduser"].'">'.'Upomnij użytkownika'.'</a>'.
                '</button>'.'</td>'.'</tr>';
        }
        echo '</table>';
    }
}
?>
<?php require_once '../views/containers/footer.php'; ?>