<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<form action="<?= baseUrl() . '/includes/editdog.inc.php'?>" method="post" enctype="multipart/form-data">
    <input type = "text" name="name" placeholder="Jak się wabi twój pies">
    <select name ='size'>
        <option>Wybierz rozmiar psa...</option>
        <option>Mały</option>
        <option>Średni</option>
        <option>Duży</option>
    </select>
    <input type = "text" name="opis" placeholder="Opisz Twojego psa">
    <input type="file" name="file" >
    <button type = "submit" name ="submit">Wyślij</button>
</form>
<?php require_once '../containers/footer.php'; ?>
