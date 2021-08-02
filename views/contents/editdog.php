<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php 
    
?>
<div class="container">
    <div class="form-group">
        <form action="<?= baseUrl() . '/includes/editdog.inc.php'?>" method="post" enctype="multipart/form-data">
            <input class="form-control" type = "text" name="name" placeholder="Jak się wabi twój pies" value="<?= isset($userDogData->name) ? $userDogData->name : "" ?>">
            <select class="custom-select" name ='size'>
                <option>Wybierz rozmiar psa...</option>
                <option>Mały</option>
                <option>Średni</option>
                <option>Duży</option>
            </select>
            <textarea class="form-control" type = "text" name="opis" placeholder="Opisz Twojego psa"><?= isset($userDogData->opis) ? $userDogData->opis : "" ?></textarea>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="file" name="file">
                <label class="custom-file-label" for="file">Wybierz zdjęcie</label>
            </div>
            <button class="btn btn-dark" type = "submit" name ="submit">Wyślij</button>
        </form>
    </div>
</div>

<?php require_once '../containers/footer.php'; ?>
