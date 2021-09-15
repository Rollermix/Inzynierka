<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<div class="container custom-container">
    <section class="city-form">
        <h2 class="h2 text-center">
            Dodaj miasto
        </h2>
        <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "errorinputvoivodship") {
                echo "<p class='text-center custom-error'>Nie wybrałeś województwa</p>";
            }
            if ($_GET["error"] == "emptyinputcity") {
                echo "<p class='text-center custom-error'>Nie wpisałeś nazwy miasta</p>";
            }
            if ($_GET["error"] == "none") {
                echo "<p class='text-center custom-success'>Pomyślnie dodano miasto!</p>";
            }
        }
        ?>
        <form action="includes/addcity.inc.php" method="post" class="just-normal-form">
            <label>
                <select name='voivodship' class="custom-select">
                    <option>Wybierz województwo...</option>
                    <?php
                    $sqli = "SELECT id,name FROM voivodship";
                    $result = mysqli_query($conn, $sqli);
                    while ($row = mysqli_fetch_array($result)) {

                        echo '<option>' . $row['name'] . '</option>';
                    }
                    ?>
                </select>
            </label>
            <label>
                <input type="text" name="name" placeholder="Nazwa miasta" class="form-control">
            </label>
            <label>
                <textarea type="text" name="description" placeholder="Krótki opis miasta" class="form-control" rows="10"></textarea>
            </label>
            <button class="btn btn-dark" type="submit" name="submit">Dodaj miasto</button>
        </form>
    </section>
    <br>
    <h4 class="h4 text-center">Treść sugestii</h4>
    <?php
    if (isset($_GET["acceptcity"])) {
        $id = $_GET["acceptcity"];
        $sqli = "SELECT suggestion FROM suggestions WHERE id=" . $id;
        $result = mysqli_query($conn, $sqli);
        while ($row = mysqli_fetch_array($result)) {

            echo '<p style="border: 1px solid black; padding: 15px;">' . $row['suggestion'] . '</p>';
        }
        acceptSuggestion($id, $conn);
    }

    ?>
</div>
<?php require_once '../views/containers/footer.php'; ?>
