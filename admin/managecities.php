<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
    <div class="container custom-menu">
        <ul class="nav nav-tabs custom-tabs">
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="suggestions.php" role="tab">Zarządzaj sugestiami</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="managenotification.php" role="tab">Zarządzaj zgłoszeniami</a>
            </li>
            <li class="nav-item active" role="presentation">
                <a class="nav-link active" href="addcity.php" data-toggle="tab" role="tab" aria-selected="true">Dodaj
                    miasto</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="manageusers.php" role="tab">Zarządzaj użytkownikami</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="managespots.php" role="tab">Zarządzaj miejscami</a>
            </li>
        </ul>
        <form action="includes/managecities.inc.php" method="post" class="just-normal-form">
            <h2 class="text-center">
                Dodaj miasto
            </h2>
            <br>
            <div class="d-flex flex-column">
                <label>
                    <select class="custom-select" name='voivodship'>
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
                    <input class="form-control" type="text" name="name" placeholder="Wpisz nazwę miasta...">
                </label>
                <label>
                    <input class="form-control" type="text" name="description" placeholder="Dodaj krótki opis...">
                </label>
                <button class="btn btn-dark btn-custom" type="submit" name="submit">Dodaj miasto</button>
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
            </div>
        </form>
        <br>
        <br>
        <table class="table table-hover">
            <thead>
            <tr class="bg-dark">
                <th scope="col">Miasto</th>
                <th scope="col">Akcje do wykonania</th>
            </tr>
            </thead>
            <?php
            $sqli = "SELECT name,deleted FROM city";
            $result = mysqli_query($conn, $sqli);

            while ($row = mysqli_fetch_array($result)) {
                if (!$row['deleted']) {
                    $curr = $row['name'];
                    echo "<tr><td>" . $row['name'] . '</td><td><a class="btn btn-success" href ="editcity.php?edit=' . $curr . '">' . ' Edytuj' . '</a>   ' .
                        '<a class="btn btn-danger" href ="includes/managecities.inc.php?delete=' . $curr . '">' . ' Usuń ' . '</a>' . '</td></tr>';
                }
            }
            ?>
        </table>
    </div>
<?php require_once '../views/containers/footer.php'; ?>