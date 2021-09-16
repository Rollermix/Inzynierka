<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<div class="container custom-menu">
    <ul class="nav nav-tabs custom-tabs">
        <li class="nav-item active" role="presentation">
            <a class="nav-link active" href="suggestions.php" data-toggle="tab" role="tab" aria-selected="true">Zarządzaj sugestiami</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="managenotification.php" role="tab">Zarządzaj zgłoszeniami</a>
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
    <h2 class="h2 text-center">
        Zgłoszone sugestie
    </h2>
    <br>
<?php
$sqli = "SELECT suggestions.id AS 'id',suggestions.id_user AS 'iduser', suggestions.id_status,suggestions.suggestion, status.status From suggestions INNER JOIN status 
    ON suggestions.id_status = status.id ORDER BY suggestions.id_status ASC";
$result = mysqli_query($conn, $sqli);

if(mysqli_num_rows($result)>0)
{

     echo '<table class="table table-hover">'
         .'<thead><tr class="bg-dark">'
         .'<th class="col">Nazwa</th>'
         .'<th class="col">Status</th>'
         .'<th class="col">Akcje</th>'
     .'</tr></thead>';
     echo '<tbody>';
     while ($row = mysqli_fetch_array($result)) {
         $statusClass = '';
         $actionButtons = '';
         switch($row['status']) {
             case 'Nie odczytano':
                readSuggestion($row["id"], $conn);
                 break;
             case 'W trakcie':
                 $actionButtons = '<a class="btn btn-secondary mr-2" href="addcity.php?acceptcity='.$row["id"].'">'.'Dodaj miasto'.'</a>'
                                  .'<a class="btn btn-secondary mr-2" href="managespots.php?acceptspot='.$row["id"].'">'.'Dodaj spot'.'</a>'
                                  .'<a class="btn btn-secondary mr-2" href="includes/suggestions.inc.php?discard='.$row["id"].'">'.'Odrzuć'.'</a>';
                 break;
             case 'Zaakceptowano':
                 break;
             case 'Odrzucono':
                 $actionButtons = '<a class="btn btn-secondary" href="reminduser.php?iduser='.$row["iduser"].'">'.'Upomnij użytkownika'.'</a>';
                 break;

         }
         echo '<tr class="'.$statusClass.
         '"><td>'.$row['suggestion'].'</td>'
         .'<td>'. $row['status'] .'</td>'
         .'<td>'. $actionButtons .'</td>' .'</tr>';
     }
     echo '</tbody>';
     echo '</table>';
}
?>

</div>
<?php require_once '../views/containers/footer.php'; ?>