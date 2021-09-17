<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container custom-container">
    <h2 class="h2 text-center">Edytuj spacer</h2>
    <br>
    <?php
    $idwalk = $_GET["id"];
    echo '<form action="' . baseUrl() . '/includes/editwalk.inc.php?id=' . $idwalk . '" method="post" class="just-normal-form">';
    ?>
    <label>
        <select name='spot' class="custom-select">
            <option>Wybierz miejsce</option>
            <?php
            $sqli = "SELECT spot.name, spot.id, spot.deleted FROM spot INNER JOIN city ON spot.id_city=city.id WHERE city.id=(SELECT id_city FROM user WHERE id=" . $_SESSION["userid"] . ")";
            $result = mysqli_query($conn, $sqli);
            while ($row = mysqli_fetch_array($result)) {
                if ($row['deleted'] == 0) {
                    echo '<option ' .setSelectValue(getWalkData($conn, $idwalk)[1], $row['id']).' >' . $row['name'] . '</option>';
                }
            }
            ?>
        </select>
    </label>
    <?php
    ?>
    <label>
        <input class="form-control" type="datetime-local" name="date" value="<?= mb_substr(implode('T', mb_split(' ', getWalkData($conn, $idwalk)[4])), 0, 16) ?>">
    </label>
    <label>
        <textarea rows="10" class="form-control" type="text" name="description" placeholder="Opis"><?=getWalkData($conn, $idwalk)[5]?></textarea>
    </label>
    <button class="btn btn-dark" type="submit" name="submit">Edytuj spacer</button>

    </form>
</div>
<?php require_once '../containers/footer.php'; ?>
