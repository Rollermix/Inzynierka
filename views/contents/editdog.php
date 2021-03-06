<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php $userDogData = getDogDetailsByUserId($conn, $_SESSION["userid"]);
    if(!$userDogData) {
        header("location: " . baseUrl() . "/views/contents/adddog.php");
        exit();
    }
?>
    <div class="container custom-container">
        <div class="form-group d-flex justify-content-center" id="add-edit-dog">
            <form action="<?= baseUrl() . '/includes/editdog.inc.php' ?>" method="post"
                  enctype="multipart/form-data"
                  class="dog-form">
                <h2 class="h2 text-center">Edytuj dane psa</h2>
                <?php
                if (isset($_GET["error"])) {
                    switch ($_GET["error"]) {
                        case "emptyinput":
                            echo "<p class='text-center custom-error'>Wypełnij wszystkie pola!</p>";
                            break;
                    }
                }
                ?>
                <label>
                    <input class="form-control" type="text" name="name" placeholder="Jak się wabi twój pies"
                           value="<?= $userDogData['name'] ?>">
                </label>
                <label>
                    <select class="custom-select" name='size'>
                        <option>Wybierz rozmiar psa...</option>
                        <option <?= setSelectValue($userDogData['size'], 'Mały') ?>>Mały</option>
                        <option <?= setSelectValue($userDogData['size'], 'Średni') ?>>Średni</option>
                        <option <?= setSelectValue($userDogData['size'], 'Duży') ?>>Duży</option>
                    </select>
                </label>
                <label>
                        <textarea class="form-control" type="text" name="opis"
                                  placeholder="Opisz Twojego psa"><?= $userDogData['opis'] ?></textarea>
                </label>
                <label>
                    <input class="form-control" type="file" name="file">
                </label>

                <?php
                if ($userDogData['image_path']) {
                    echo "<h4 class='h4 text-center'>Obecne zdjęcie psa</h4>";
                    echo "<br>";
                    echo '<img alt="obraz psa" src="' . $CONFIG->dog_images_path . $userDogData['image_path'] . '" width="500">';
                    echo '<br>';
                }
                ?>
                <button class="btn btn-dark" type="submit" name="submit">Wyślij</button>
            </form>
        </div>
    </div>
<?php require_once '../containers/footer.php'; ?>