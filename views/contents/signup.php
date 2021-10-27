<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php
redirectIfLoggedIn()
?>
<div class="container register-container">
    <div class="form-group d-flex justify-content-center">
        <div class="register-form">
            <form action="<?= baseUrl() . "/includes/signup.inc.php" ?>" method="post">
                <h2 class="h2 text-center">Zarejestruj się</h2>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p class='text-center custom-error'>Wypełnij wszystkie pola!</p>";
                    } else if ($_GET["error"] == "invalidlogin") {
                        echo "<p class='text-center custom-error'>Niepoprawny login! Używaj 
                        tylko takich znaków: a-zA-Z0-9</p>";
                    } else if ($_GET["error"] == "passworddontmatch") {
                        echo "<p class='text-center custom-error'>Wprowadziłeś różne hasła.</p>";
                    } else if ($_GET["error"] == "invalidemail") {
                        echo "<p class='text-center custom-error'>Wprowadziłeś zły adres e-mail</p>";
                    } else if ($_GET["error"] == "logintaken") {
                        echo "<p class='text-center custom-error'>Login lub email zajęty</p>";
                    } else if ($_GET["error"] == "stmtfailed") {
                        echo "<p class='text-center custom-error'>Something went wrong, try again!</p>";
                    } else if ($_GET["error"] == "none") {
                        echo "<p class='text-center custom-success'>Zarejestrowałeś się!</p>";
                    }
                }
                ?>
                <label for="firstname">
                    <span>Podaj swoje imię:</span>
                    <input class="form-control" type="text" name="firstname" placeholder="Imię" required="required">
                </label>
                <label for="lastname">
                    <span>Podaj swoje nazwisko:</span>
                    <input class="form-control" type="text" name="lastname" placeholder="Nazwisko" required="required">
                </label>
                <label for="city">
                    <span>Wybierz miejsce zamieszkania:</span>
                    <select class="custom-select" name='city' title="city"
                            style="margin-bottom: 5px !important;" required="required">
                        <option>Wybierz miasto...</option>
                        <?php
                        $sqli = "SELECT name FROM city";
                        $result = mysqli_query($conn, $sqli);
                        while ($row = mysqli_fetch_array($result)) {

                            echo '<option>' . $row['name'] . '</option>';
                        }
                        ?>
                    </select>
                </label>
                <label for="email">
                    <span>Podaj adres e-mail:</span>
                    <input class="form-control" type="text" name="email" placeholder="Wpisz email..." required="required">
                </label>
                <label for="login">
                    <span>Podaj Twoją nazwę użytkownika:</span>
                    <input class="form-control" type="text" name="login" placeholder="Nazwa użytkownika" required="required">
                </label>
                <label for="password">
                    <span>Wpisz hasło:</span>
                    <input class="form-control" type="password" name="password" id="password" placeholder="Hasło" required="required">
                </label>
                <label for="repeatpassword">
                    <span>Ponownie wprowadź hasło:</span>
                    <input class="form-control" type="password" name="repeatpassword" placeholder="Powtórz hasło" required="required">
                </label>
                <label for="description">
                    <span>W kilku słowach opisz, kim jesteś:</span>
                    <textarea class="form-control" type="text" name="description"
                              placeholder="Opisz siebie..." rows="10" required="required"></textarea>
                </label>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-success btn-login" type="submit" name="submit">Zarejestruj się</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once '../containers/footer.php'; ?>
