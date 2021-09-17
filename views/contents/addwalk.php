<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container custom-container">
    <form action="<?= baseUrl() . '/includes/addwalk.inc.php' ?>" method="post" class="just-normal-form">
        <h2 class="h2 text-center">Dodaj spacer</h2>
        <br>
        <label>
            <select name='spot' class="custom-select">
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
        </label>
        <label>
            <input class="form-control" type="datetime-local" name="date">
        </label>
        <label>
            <textarea rows=10 class="form-control" type="text" name="description" placeholder="Opis spaceru"></textarea>
        </label>
        <button class="btn btn-success" type="submit" name="submit">Dodaj spacer</button>
    </form>
</div>

<?php require_once '../containers/footer.php'; ?>
