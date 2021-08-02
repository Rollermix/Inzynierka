<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container">
    <section class="dog">
        <div class="form-group d-flex justify-content-center" id="add-edit-dog">
            <form action="<?= baseUrl() . '/includes/adddog.inc.php'?>" method="post" enctype="multipart/form-data">
                <input class="form-control" type = "text" name="name" placeholder="Jak się wabi twój pies">
                <select class="custom-select" name ='size'>
                    <option>Wybierz rozmiar psa...</option>
                    <option>Mały</option>
                    <option>Średni</option>
                    <option>Duży</option>
                </select>
                <textarea class="form-control" type = "text" name="opis" placeholder="Opisz Twojego psa"></textarea>
                <input class="form-control" type="file" name="file" >
                <button class="btn btn-success" type = "submit" name ="submit">Wyślij</button>
            </form>
        </div>
    </section>
</div>
<?php require_once '../containers/footer.php'; ?>
