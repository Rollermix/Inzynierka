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
<a>DOGGO WALKS</a>

<?php
if (isset($_SESSION["useruid"]))
{
    echo  "<p>Witaj ".$_SESSION["useruid"]."</p>";

}

?>
<a>Dostępne miasta:</a>
<table>
    <tr>
        <th>
            Województwo
        </th>
        <th>
            Miasto
        </th>
        <th>
            Opis
        </th>
    </tr>
    <?php
    $sqli = "SELECT voivodship.name AS 'województwo', city.name, city.description,city.deleted From voivodship Inner Join city ON city.id_voivodship=voivodship.id";
    $result = mysqli_query($conn, $sqli);
    while ($row = mysqli_fetch_array($result)) {
        if($row['deleted']==0) {
           echo '<tr>'.'<td>'.$row['województwo'].'</td>'.'<td>'.$row['name'].'</td>'.'<td>'.$row['description'].'</td>'.'</tr>';
        }
    }
    ?>
</table>
</body>
</html>