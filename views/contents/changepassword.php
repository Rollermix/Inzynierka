<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php
$sqli = "SELECT * FROM user WHERE login='" . $_SESSION["useruid"] . "'";
$result = mysqli_query($conn, $sqli);
$userdata = mysqli_fetch_array($result);
$_SESSION["idchanging"] = $userdata['id'];

?>
<div class="container custom-menu custom-container">
    <ul class="nav nav-tabs custom-tabs">
        <li class="nav-item" role="presentation" role="tab">
            <a class="nav-link" href="profile.php">Wyświetl profil</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="manageaccount.php" role="tab">Edytuj dane konta</a>
        </li>
        <li class="nav-item active" role="presentation">
            <a class="nav-link active" href="changepassword.php" data-toggle="tab" role="tab" aria-selected="true">Zmień
                hasło</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="deleteaccount.php" role="tab">Usuń konto</a>
        </li>
    </ul>
    <div class="tab-pane fade show active">
        <section class="change-password-form">
            <h2 class="text-center">
                Zmień hasło do konta
            </h2>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p class='text-center custom-error'>Wypełnij wszystkie pola!</p>";
                } else if ($_GET["error"] == "invalidlogin") {
                    echo "<p class='text-center custom-error'>Niepoprawny login!</p>";
                } else if ($_GET["error"] == "passworddontmatch") {
                    echo "<p class='text-center custom-error'>Wprowadziłeś różne hasła</p>";
                } else if ($_GET["error"] == "wrongpassword") {
                    echo "<p class='text-center custom-error'>Obecne hasło jest nieprawidłowe</p>";
                } else if ($_GET["error"] == "logintaken") {
                    echo "<p class='text-center custom-error'>Login zajęty</p>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<p class='text-center custom-error'>Something went wrong, try again!</p>";
                } else if ($_GET["error"] == "none") {
                    echo "<p class='text-center custom-success'>Zmieniłeś dane konta</p>";
                }
            }
            ?>
            <div class="form-group d-flex justify-content-center" id="change_password">
                <form action="<?= baseUrl() . '/includes/changepassword.inc.php' ?>" method="post">
                    <p class="text-center">Wpisz obecne hasło, a następnie podaj 2 razy nowe hasło, <br>którym
                        będziesz logować się do aplikacji</p>
                    <input class="form-control" type="password" name="password" placeholder="Wpisz obecne hasło"
                           autocomplete='off'>
                    <input class="form-control" type="password" name="newpassword" placeholder="Wpisz nowe hasło"
                           autocomplete="off">
                    <input class="form-control" type="password" name="repeatnewpassword"
                           placeholder="Powtórz nowe hasło" autocomplete="off">
                    <button class="btn btn-success" type="submit" name="submit2">Zmień hasło</button>
                    <input type="hidden" name="username" id="username" value="<?= $userdata['login'] ?>">
                </form>
            </div>
        </section>
    </div>
</div>

<?php require_once '../containers/footer.php'; ?>
