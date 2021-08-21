<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>

<div class="container">

<?php
$id = $_SESSION["userid"];
$sqli = "SELECT blocked From user WHERE id ='".$id."'";
$result = mysqli_query($conn, $sqli);
$row = mysqli_fetch_array($result);
if ($row['blocked']==0) {
    echo '<h1 class="text-center">Co chciałbyś, aby znalazło się w naszym systemie?</h1>';
    echo '<p class="text-center">W poniższym formularzu możesz przekazać nam informacje dotyczące rozszerzenia funkcjonalności portalu lub zgłosić błąd, który występuje na stronie.</p>';
    echo '<div class="form-group d-flex justify-content-center">';
        echo '<form action="'.baseUrl().'/includes/suggestion.inc.php" method="post">';
            echo '<textarea class="form-control" type = "text" name="name" rows="15"></textarea>';
            echo '<button class="btn btn-success" type = "submit" name ="submit">Wyślij</button>';
        echo '</form>';
    echo '</div>';
}
else if ($row['blocked']==2)
{
    echo "<p>Nie możesz wysyłać sugestii.</p>";
}
?>
<?php
$id = $_SESSION["userid"];
$sqli = "SELECT suggestions.id_status,suggestions.suggestion, status.status From suggestions INNER JOIN status 
    ON suggestions.id_status = status.id WHERE id_user ='".$id."'";
$result = mysqli_query($conn, $sqli);

if(mysqli_num_rows($result))
{
    echo '<table class="table table-hover">'.'<thead><tr class="bg-dark">'.'<th class="col">Nazwa</th>'.'<th class="col">Status</th>'.'</tr></thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_array($result)) {
        $statusClass = 'table-secondary';
        switch($row['status']) {
            case 'Nie odczytano': 
                $statusClass = 'table-secondary';
                break;
            case 'W trakcie':
                $statusClass = 'table-info';
                break;
            case 'Zaakceptowano':
                $statusClass = 'table-success';
                break;
            case 'Odrzucono':
                $statusClass = 'table-danger';
                break;
                
        }
        echo '<tr class="'.$statusClass.'"><td>'.$row['suggestion'].'</td>' .'<td>'. $row['status'] .'</td>' .'</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
else {
    echo "nie zgłaszałeś nam nic!";
}

$sqli = "SELECT reminder.*,user.login From reminder INNER JOIN user ON reminder.id_sending_user = user.id WHERE reminder.id_user ='".$id."'";
$result = mysqli_query($conn, $sqli);

if(mysqli_num_rows($result))
{
    echo '<h3>Twoje upomnienia</h3>';
    echo '<table class="table table-hover">'.'<thead><tr class="bg-dark">'.'<th class="col">Treść</th>'.'<th class="col">Data</th>'.'<th class="col">Kto wysłał</th>'.'</tr>'.'</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_array($result)) {
        readReminder($conn,$row['id']);
        echo '<tr class="table-warning"><td>' . $row['Message'] . '</td>' . '<td>' . $row['Date'] . '</td>' . '<td>' . $row['login'] . '</td>' . '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
}
?>
</div>

<?php require_once '../containers/footer.php'; ?>
