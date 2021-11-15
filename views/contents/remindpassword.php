<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php
redirectIfLoggedIn()
?>
<div class="container">
    <div class="form-group d-flex justify-content-center">
        <div class="remind-form">
            <form action="<?= baseUrl() . '/includes/login.inc.php' ?>" method="post">
                <h2 class="h2 text-center">Przypomnij hasło</h2>
                <label for="username">
                    <br>
                    <span>Na powiazany adres e-mail zostanie wysłana wiadomość <br>z dalszymi instrukcjami dotyczącymi odzyskiwania konta.</span>
                    <input class="form-control" type="text" name="name" id="username"
                           placeholder="Nazwa użytkownika lub email" style="width: 100%; margin-top: 25px" required="required">
                </label>
                <div class="d-flex justify-content-center" style="padding-top: 25px;">
                    <button class="btn btn-success btn-login" type="submit" name="submit2">Resetuj hasło</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if (isset($_GET["error"])) {
    switch ($_GET["error"]) {
        case "emptylogin":
            echo "<p class='text-center custom-error'>Wypełnij wszystkie pola!</p>";
            break;
        case "wrongLogin":
            echo "<p class='text-center custom-error'>W systemie nie ma użytkownika o podanym mailu lub loginie</p>";
            break;
        case "remindnone":
            echo "<p class='text-center custom-success'>Na powiązane konto e-mail została wysłana wiadomość z dalszymi instrukcjami.</p>";
            break;
    }
}
?>
<?php require_once '../containers/footer.php'; ?>
