<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<section class="city-form">
    <h2>
        Dodaj miasto
    </h2>
    <form action="includes/managecities.inc.php" method="post">
        <form method ="POST">
            <select name ='voivodship'>
                <option>Wybierz województwo...</option>
                <?php
                $sqli = "SELECT id,name FROM voivodship";
                $result = mysqli_query($conn, $sqli);
                while ($row = mysqli_fetch_array($result)) {

                    echo '<option>'.$row['name'].'</option>';
                }
                ?>
            </select>
        <input type = "text" name="name" placeholder="Wpisz nazwę miasta...">
            <input type = "text" name="description" placeholder="Dodaj krótki opis...">
        <button type = "submit" name ="submit">Dodaj miasto</button>
    </form>
</section>
<?php
$sqli = "SELECT name,deleted FROM city";
$result = mysqli_query($conn, $sqli);
    while ($row = mysqli_fetch_array($result)) {
        if($row['deleted']==0) {
            $curr = $row['name'];
            echo $row['name'] . '<button>' . '<a href ="editcity.php?edit=' . $curr . '">' . ' Edytuj' . '</a>' . '</button>' .
                '<button>' . '<a href ="includes/managecities.inc.php?delete=' . $curr . '">' . ' Usuń ' . '</a>' . '</button>' . '<br>';
        }
}
?>
<?php
    if(isset($_GET["error"]))
    {
        if($_GET["error"]=="errorinputvoivodship")
        {
            echo"<p>Nie wybrałeś województwa</p>";
        }
        if($_GET["error"]=="emptyinputcity")
        {
            echo"<p>Nie wpisałeś nazwy miasta</p>";
        }
        if($_GET["error"]=="none")
        {
            echo"<p>Pomyślnie dodano miasto!</p>";
        }
    }

?>
<?php require_once '../views/containers/footer.php'; ?>