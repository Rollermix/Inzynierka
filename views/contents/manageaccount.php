<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php
$sqli = "SELECT * FROM user WHERE login='" . $_SESSION["useruid"] . "'";
$result = mysqli_query($conn, $sqli);
$userdata = mysqli_fetch_array($result);
$_SESSION["idchanging"] = $userdata['id'];

?>
<div class="container custom-menu custom-container">
    <ul class="nav nav-tabs custom-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="signup-tab" data-toggle="tab" href="#signup" role="tab"
               aria-controls="signup" aria-selected="true">Twoje dane</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="change-password-tab" data-toggle="tab" href="#change-password" role="tab"
               aria-controls="change-password" aria-selected="true">Zmiana hasła</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="delete-account-tab" data-toggle="tab" href="#delete-account" role="tab"
               aria-controls="delete-account" aria-selected="true">Usunięcie konta</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="signup" role="tabpanel" aria-labelledby="signup-tab">
            <section class="signup-form">
                <h2 class="text-center">
                    Zmień dane konta
                </h2>
                <div class="form-group d-flex justify-content-center" id="change_data_account">
                    <form action="<?= baseUrl() . '/includes/manageaccount.inc.php' ?>" method="post">
                        <input class="form-control" type="text" name="firstname" placeholder="Imię"
                               value="<?= $userdata['name'] ?>">
                        <input class="form-control" type="text" name="lastname" placeholder="Nazwisko"
                               value="<?= $userdata['surname'] ?>">

                        <input class="form-control" type="text" name="email" placeholder="E-mail"
                               value="<?= $userdata['email'] ?>">
                        <select class="custom-select" name='city' title="city">
                            <?php
                            $sqli = "SELECT * FROM city";
                            $result = mysqli_query($conn, $sqli);

                            while ($row = mysqli_fetch_array($result)) {

                                if (isset($userdata['id_city']) && $userdata['id_city'] == $row['id']) {
                                    echo '<option value="' . $row['name'] . '"selected="selected" >' . $row['name'] . '</option>';
                                } else {
                                    echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                }
                            }

                            if (!isset($userdata['id_city']) || !$userdata['id_city']) {
                                echo '<option value="" disabled selected hidden>Miasto</option>';
                            }

                            ?>
                        </select>
                        <br>

                        <textarea class="form-control" type="text" name="description" placeholder="Twój opis"
                                  rows="10"><?= $userdata['description'] ?></textarea>

                        <button class="btn btn-success" type="submit" name="submit">Zmień dane</button>
                    </form>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="change-password" role="tabpanel" aria-labelledby="change-password-tab">
            <section class="change-password-form">
                <h2 class="text-center">
                    Zmień hasło do konta
                </h2>
                <div class="form-group d-flex justify-content-center" id="change_password">
                    <form action="<?= baseUrl() . '/includes/changepassword.inc.php' ?>" method="post">
                        <p class="text-center">Wpisz obecne hasło, a następnie podaj 2 razy nowe hasło, <br>którym
                            będziesz logować się do aplikacji</p>
                        <input class="form-control" type="password" name="password" placeholder="Wpisz obecne hasło"
                               autocomplete="current-password">
                        <input class="form-control" type="password" name="newpassword" placeholder="Wpisz nowe hasło"
                               autocomplete="new-password">
                        <input class="form-control" type="password" name="repeatnewpassword"
                               placeholder="Powtórz nowe hasło" autocomplete="new-password">
                        <button class="btn btn-success" type="submit" name="submit2">Zmień hasło</button>
                        <input type="hidden" name="username" id="username" value="<?= $userdata['login'] ?>">
                    </form>
                </div>
            </section>
        </div>
        <div class="tab-pane fade" id="delete-account" role="tabpanel" aria-labelledby="delete-account-tab">
            <section class="delete-account-form">
                <h2 class="text-center">
                    Usuń konto
                </h2>
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
                                   name="password_delete_account" placeholder="Wpisz obecne hasło">
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
</div>


<?php
if (isset($_GET["error"])) {
    if ($_GET["error"] == "emptyinput") {
        echo "<p>Wypełnij wszystkie pola!</p>";
    } else if ($_GET["error"] == "invalidlogin") {
        echo "<p>Niepoprawny login!</p>";
    } else if ($_GET["error"] == "passworddontmatch") {
        echo "<p>Wprowadziłeś różne hasła</p>";
    } else if ($_GET["error"] == "invalidemail") {
        echo "<p>Wprowadziłeś zły email</p>";
    } else if ($_GET["error"] == "logintaken") {
        echo "<p>Login zajęty</p>";
    } else if ($_GET["error"] == "stmtfailed") {
        echo "<p>Something went wrong, try again!</p>";
    } else if ($_GET["error"] == "none") {
        echo "<p>Zmieniłeś dane konta</p>";
    }
}
?>
<?php require_once '../containers/footer.php'; ?>
