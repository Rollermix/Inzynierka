<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
    <div class="container admin-menu">
        <ul class="nav nav-tabs admin-tabs">
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="suggestions.php" role="tab">Zarządzaj sugestiami</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="managenotification.php" role="tab">Zarządzaj zgłoszeniami</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="managecities.php" role="tab">Dodaj
                    miasto</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="manageusers.php">Zarządzaj
                    użytkownikami</a>
            </li>
            <li class="nav-item active" role="presentation">
                <a class="nav-link active" href="managespots.php" data-toggle="tab" role="tab" aria-selected="true">Zarządzaj miejscami</a>
            </li>
        </ul>
        <h2>
            Zarządzaj miejscami
        </h2>
        <form action="includes/managespots.inc.php" method="post">
            <select name='city'>
                <option>Wybierz miasto...</option>
                <?php
                $sqli = "SELECT name,deleted FROM city";
                $result = mysqli_query($conn, $sqli);
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['deleted'] == 0)
                        echo '<option>' . $row['name'] . '</option>';

                }
                ?>
            </select>
            <input type="text" name="name" placeholder="Wpisz nazwę miejsca">
            <input type="text" name="description" placeholder="Dodaj krótki opis...">
            <button type="submit" name="submit">Dodaj spot</button>
        </form>
        <?php
        $sqli = "SELECT name,deleted FROM spot";
        $result = mysqli_query($conn, $sqli);
        while ($row = mysqli_fetch_array($result)) {
            $curr = $row['name'];
            if ($row['deleted'] == 0) {
                echo $row['name'] . '<button>' . '<a href ="editspot.php?edit=' . $curr . '">' . ' Edytuj' . '</a>' . '</button>'
                    . '<button>' . '<a href ="includes/managespots.inc.php?delete=' . $curr . '">' . ' Usun' . '</a>' . '</button>' . '<br>';
            }
        }
        ?>

        <?php
        if (isset($_GET["acceptspot"])) {
            $id = $_GET["acceptspot"];
            $sqli = "SELECT suggestion FROM suggestions WHERE id=" . $id;
            $result = mysqli_query($conn, $sqli);
            while ($row = mysqli_fetch_array($result)) {

                echo '<p>' . $row['suggestion'] . '</p>';
            }
            acceptSuggestion($id, $conn);
        }
        ?>
    </div>
<?php require_once '../views/containers/footer.php'; ?>