<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container">
    <div class="title">
        <h1>Od teraz spacery z psami bardziej zorganizowane!</h1>
        <div class="subtitle">Umawiaj spacery ze swoim psem - dzięki nam jest to o wiele prostsze niż wcześniej!
        </div>
    </div>
    <div class="start-menu">
        <a class="go-to-cities" href="<?= baseUrl() . '/views/contents/main.php' ?>">Do wyboru miast ➔</a>
        <a class="go-to-cities" href="<?= baseUrl() . '/views/contents/gallery.php' ?>">Do galerii psów ➔</a>
    </div>
</div>
<?php require_once '../containers/footer.php'; ?>
