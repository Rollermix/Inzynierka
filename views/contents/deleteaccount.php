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
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="changepassword.php" role="tab">Zmień hasło</a>
        </li>
        <li class="nav-item active" role="presentation">
            <a class="nav-link active" href="deleteaccount.php" data-toggle="tab" role="tab" aria-selected="true">Usuń konto</a>
        </li>
    </ul>
    <div class="tab-pane fade show active" id="delete-account" role="tabpanel" aria-labelledby="delete-account-tab">
        <section class="delete-account-form">
            <h2 class="text-center">
                Usuń konto
            </h2>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<p class='text-center custom-error'>Wypełnij wszystkie pola!</p>";
                } else if ($_GET["error"] == "invalidlogin") {
                    echo "<p class='text-center custom-error'>Niepoprawny login!</p>";
                } else if ($_GET["error"] == "wrongpassword") {
                    echo "<p class='text-center custom-error'>Wprowadziłeś złe hasło</p>";
                } else if ($_GET["error"] == "invalidemail") {
                    echo "<p class='text-center custom-error'>Wprowadziłeś zły email</p>";
                } else if ($_GET["error"] == "logintaken") {
                    echo "<p class='text-center custom-error'>Login zajęty</p>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<p class='text-center custom-error'>Something went wrong, try again!</p>";
                } else if ($_GET["error"] == "none") {
                    echo "<p class='text-center custom-success'>Zmieniłeś dane konta</p>";
                }
            }
            ?>
            <p class="text-center">Operacja usunięcia konta jest nieodwracalna. Aby potwierdzić<br>usunięcie konta,
                podaj swoje hasło, którym logujesz się do aplikacji.</p>
            <div class="form-group d-flex justify-content-start" id="delete_account">
                <form action="<?= baseUrl() . '/includes/deleteaccount.inc.php?id=' . $_SESSION["idchanging"] ?>"
                      method="post"
                      style="display: flex"
                >
                    <label style="margin-bottom: 0" for="password_delete_account">
                        <input id="password_delete_account" style="margin: 0 15px 0 0;" class="form-control"
                               type="password"
                               name="password_delete_account" placeholder="Wpisz obecne hasło" autocomplete='off'>
                    </label>
                    <?php
                    echo '<button type="submit" style="display: flex;justify-content: center;align-items: center;" class="btn btn-danger" 
                        href ="' . baseUrl() . '/includes/deleteaccount.inc.php?id=' . $_SESSION["idchanging"] . '">' . ' Usuń konto' . '</button>';
                    ?>

                </form>
            </div>
        </section>
    </div>
</div>
<?php require_once '../containers/footer.php'; ?>
