<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php
redirectIfLoggedIn()
?>
<div class="container-fluid">
    <div class="form-group d-flex justify-content-center">
        <div class="login-form">
            <form action="<?= baseUrl() . '/includes/login.inc.php' ?>" method="post">
                <h2 class="h2 text-center">Logowanie do strony</h2>
                <?php
                if (isset($_GET["error"])) {
                    switch ($_GET["error"]) {
                        case "emptyinput":
                            echo "<p class='text-center custom-error'>Wypełnij wszystkie pola!</p>";
                            break;
                        case "wronglogin":
                        case "wrongPassword":
                            echo "<p class='text-center custom-error'>Niepoprawne dane logowania!</p>";
                            break;
                        case "stmtfailed":
                            echo "<p class='text-center custom-error'>Błąd podczas logowania, proszę zwróć się do administratora o pomoc.</p>";
                            break;
                        case "accountblocked":
                            echo "<p class='text-center custom-error'>Konto zablokowane. Jeżeli uważasz, że to błąd, zwróć się proszę do administratora.</p>";
                            break;
                        case "none":
                            break;
                        case "remindnone":
                            echo "<p class='text-center custom-success'>Hasło zostało wysłane na maila!</p>";
                            break;
                    }
                }
                ?>
                <label for="username"></label>
                <input class="form-control" type="text" name="name" id="username"
                       placeholder="Nazwa użytkownika lub email">
                <label for="password"></label>
                <input class="form-control" type="password" name="password" id="password" placeholder="Hasło">
                <div class="d-flex justify-content-between login-actions">
                    <div>
                        <input type="checkbox" class="" id="remember-user">
                        <label for="remember-user">Zapamiętaj login</label>
                    </div>
                    <div>
                        <a class="nav-link" style="padding: 0; color: black" href="<?= baseUrl() , '/views/contents/remindpassword.php'?>">Przypomnij hasło</a>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-success btn-login" type="submit" name="submit">Zaloguj się</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once '../containers/footer.php'; ?>
