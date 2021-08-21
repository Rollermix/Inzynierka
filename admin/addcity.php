<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<?php
require_once 'adminheader.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/adminfunctions.inc.php';
isLogged();
?>

<section class="city-form">
    <h2>
        Dodaj miasto
    </h2>
    <form action="includes/addcity.inc.php" method="post">
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
    if(isset($_GET["acceptcity"]))
    {
        $id=$_GET["acceptcity"];
        $sqli = "SELECT suggestion FROM suggestions WHERE id=".$id;
        $result = mysqli_query($conn, $sqli);
        while ($row = mysqli_fetch_array($result)) {

            echo '<p>'.$row['suggestion'].'</p>';
        }
        acceptSuggestion($id,$conn);
    }

?>
<?php require_once '../views/containers/footer.php'; ?>
