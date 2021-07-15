<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Praca inżynierska-logowanie</title>
</head>
<body>
<?php
require_once 'adminheader.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/adminfunctions.inc.php';
isLogged();
?>

    <h2>
        Zarządzaj miejscami
    </h2>
<form action="includes/managespots.inc.php" method="post">
        <select name ='city'>
            <option>Wybierz miasto...</option>
            <?php
            $sqli = "SELECT name,deleted FROM city";
            $result = mysqli_query($conn, $sqli);
            while ($row = mysqli_fetch_array($result)) {
                    if($row['deleted']==0)
                echo '<option>'.$row['name'].'</option>';

            }
            ?>
        </select>
        <input type = "text" name="name" placeholder="Wpisz nazwę miejsca">
        <input type = "text" name="description" placeholder="Dodaj krótki opis...">
        <button type = "submit" name ="submit">Dodaj spot</button>
    </form>
    <?php
    $sqli = "SELECT name,deleted FROM spot";
    $result = mysqli_query($conn, $sqli);
    while ($row = mysqli_fetch_array($result)) {
        $curr = $row['name'];
        if($row['deleted']==0) {
            echo $row['name'] . '<button>' . '<a href ="editspot.php?edit=' . $curr . '">' . ' Edytuj' . '</a>' . '</button>'
                . '<button>' . '<a href ="includes/managespots.inc.php?delete=' . $curr . '">' . ' Usun' . '</a>' . '</button>' . '<br>';
        }
    }
    ?>

<?php
if(isset($_GET["acceptspot"]))
{
    $id=$_GET["acceptspot"];
    $sqli = "SELECT suggestion FROM suggestions WHERE id=".$id;
    $result = mysqli_query($conn, $sqli);
    while ($row = mysqli_fetch_array($result)) {

        echo '<p>'.$row['suggestion'].'</p>';
    }
    acceptSuggestion($id,$conn);
}
?>
</body>
</html>