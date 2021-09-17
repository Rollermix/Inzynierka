<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<?php
canViewAsAdmin($conn);
?>
    <div class="container custom-menu">
        <ul class="nav nav-tabs custom-tabs">
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
                <a class="nav-link active" href="managespots.php" data-toggle="tab" role="tab" aria-selected="true">Zarządzaj
                    miejscami</a>
            </li>
        </ul>
        <?php
        if (isset($_GET["acceptspot"])) {
            echo "<h4 class='h4 text-center'>Treść sugestii</h4>";
            echo '<div style="border: 1px solid black; padding: 15px">';

            $id = $_GET["acceptspot"];
            $sqli = "SELECT suggestion FROM suggestions WHERE id=" . $id;
            $result = mysqli_query($conn, $sqli);
            while ($row = mysqli_fetch_array($result)) {
                echo $row['suggestion'];
            }
            echo "</div>";
            echo "<br>";
            acceptSuggestion($id, $conn);
        }
        ?>
        <h2 class="h2 text-center">
            Zarządzaj miejscami
        </h2>
        <br>
        <form action="includes/managespots.inc.php" method="post" class="just-normal-form">
            <label>
                <select class="custom-select" name='city'>
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
            </label>
            <label>
                <input class="form-control" type="text" name="name" placeholder="Wpisz nazwę miejsca">
            </label>
            <label>
                <input class="form-control" type="text" name="description" placeholder="Dodaj krótki opis...">
            </label>
            <button style="height: 60px;" class="btn btn-dark" type="submit" name="submit">Dodaj spot</button>
        </form>
        <br>
        <br>
        <table class="table table-hover">
            <thead>
            <tr class="bg-dark">
                <td>Nazwa spotu</td>
                <td>Akcje</td>
            </tr>
            </thead>
            <tbody>
            <?php
            $sqli = "SELECT name,deleted FROM spot";
            $result = mysqli_query($conn, $sqli);
            while ($row = mysqli_fetch_array($result)) {
                $curr = $row['name'];
                if ($row['deleted'] == 0) {
                    echo "<tr>";
                    echo "<td>";
                    echo $row['name'];
                    echo "</td>";
                    echo "<td>";
                    echo '<a class="btn btn-success" href ="editspot.php?edit=' . $curr . '">' . ' Edytuj' . '</a> ' .
                         '<a class="btn btn-danger" href ="includes/managespots.inc.php?delete=' . $curr . '">' . ' Usuń' . '</a>';
                    echo "</td>";
                    echo "</tr>";
                }
            }
            ?>
            </tbody>
        </table>

    </div>
<?php require_once '../views/containers/footer.php'; ?>