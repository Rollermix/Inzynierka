<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php
if (getDogDetailsByUserId($conn, $_SESSION["userid"])) {
    header("location: " . baseUrl() . "/views/contents/editdog.php");
    exit();
}
?>
<div class="container custom-container">
    <h2 class="h2 text-center">Dodaj psa</h2>
    <?php
    if (isset($_GET["error"])) {
        switch ($_GET["error"]) {
            case "emptyinput":
                echo "<p class='text-center custom-error'>Wypełnij wszystkie pola!</p>";
                break;
        }
    }
    ?>
    <div class="form-group d-flex justify-content-center" id="add-edit-dog">
        <form action="<?= baseUrl() . '/includes/adddog.inc.php' ?>" method="post" enctype="multipart/form-data"
              class="dog-form">
            <label>
                <input class="form-control" type="text" name="name" placeholder="Jak się wabi twój pies">
            </label>
            <label>
                <select class="custom-select" name='size' style="margin-bottom: 0">
                    <option>Wybierz rozmiar psa...</option>
                    <option>Mały</option>
                    <option>Średni</option>
                    <option>Duży</option>
                </select>
            </label>
            <label>
                <input class="form-control" type="text" name="opis" placeholder="Opisz Twojego psa">
            </label>
            <label>
                <input class="form-control" type="file" name="file">
            </label>
            <button class="btn btn-dark" type="submit" name="submit">Dodaj psa</button>
        </form>
    </div>
</div>
<?php require_once '../containers/footer.php'; ?>
