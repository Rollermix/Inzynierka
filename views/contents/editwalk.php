<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container custom-container">
    <?php
    $idwalk = $_GET["id"];
    echo '<form action="' . baseUrl() . '/includes/editwalk.inc.php?id=' . $idwalk . '" method="post">';
    ?>
    <select name='spot'>
        <option>Wybierz miejsce</option>
        <?php
        $sqli = "SELECT spot.name FROM spot INNER JOIN city ON spot.id_city=city.id WHERE city.id=(SELECT id_city FROM user WHERE id=" . $_SESSION["userid"] . ")";
        $result = mysqli_query($conn, $sqli);
        while ($row = mysqli_fetch_array($result)) {
            if ($row['deleted'] == 0)
                echo '<option>' . $row['name'] . '</option>';

        }
        ?>
    </select>
    <input type="datetime-local" name="date">
    <input type="text" name="description" placeholder="Opis...">
    <button type="submit" name="submit">Edytuj spacer</button>

    </form>
</div>
<?php require_once '../containers/footer.php'; ?>
