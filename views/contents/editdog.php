<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php $userDogData = getDogDetailsByUserId($conn, $_SESSION["userid"]); ?>
    <div class="container">
        <section class="dog">
            <div class="form-group d-flex justify-content-center" id="add-edit-dog">
                <form action="<?= baseUrl() . '/includes/editdog.inc.php'?>" method="post" enctype="multipart/form-data">
                    <input class="form-control" type = "text" name="name" placeholder="Jak się wabi twój pies" value="<?= $userDogData['name'] ?>">
                    <select class="custom-select" name ='size'>
                        <option>Wybierz rozmiar psa...</option>
                        <option <?= setSelectValue($userDogData['size'], 'Mały') ?>>Mały</option>
                        <option <?= setSelectValue($userDogData['size'], 'Średni') ?>>Średni</option>
                        <option <?= setSelectValue($userDogData['size'], 'Duży') ?>>Duży</option>
                    </select>
                    <textarea class="form-control" type = "text" name="opis" placeholder="Opisz Twojego psa"><?=$userDogData['opis'] ?></textarea>
                    <input class="form-control" type="file" name="file" >
                    <?php 
                        if($userDogData['image_path']) {
                            echo '<img alt="obraz psa" src="'. $CONFIG->dog_images_path . $userDogData['image_path'] . '" width="500">';
                            echo '<br>';
                        }
                    ?>
                    <button class="btn btn-dark" type = "submit" name ="submit">Wyślij</button>
                </form>
            </div>
        </section>
    </div>
<?php require_once '../containers/footer.php'; ?>