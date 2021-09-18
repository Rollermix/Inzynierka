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
        <li class="nav-item active" role="presentation">
            <a class="nav-link active" href="manageaccount.php" data-toggle="tab" role="tab" aria-selected="true">Edytuj
                dane konta</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="changepassword.php" role="tab">Zmień hasło</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="deleteaccount.php" role="tab">Usuń konto</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active">
            <section class="signup-form">
                <h2 class="text-center">
                    Zmień dane konta
                </h2>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "emptyinput") {
                        echo "<p class='text-center custom-error'>Wypełnij wszystkie pola!</p>";
                    } else if ($_GET["error"] == "invalidlogin") {
                        echo "<p class='text-center custom-error'>Niepoprawny login!</p>";
                    } else if ($_GET["error"] == "passworddontmatch") {
                        echo "<p class='text-center custom-error'>Wprowadziłeś różne hasła</p>";
                    } else if ($_GET["error"] == "invalidemail") {
                        echo "<p class='text-center custom-error'>Wprowadziłeś zły email</p>";
                    } else if ($_GET["error"] == "logintaken") {
                        echo "<p class='text-center custom-error'>Login zajęty</p>";
                    } else if ($_GET["error"] == "emptyname") {
                        echo "<p class='text-center custom-error'>Musisz podać imię</p>";
                    } else if ($_GET["error"] == "emptysurname") {
                        echo "<p class='text-center custom-error'>Musisz podać nazwisko</p>";
                    } else if ($_GET["error"] == "emptyemail") {
                        echo "<p class='text-center custom-error'>Adres e-mail jest wymagany</p>";
                    } else if ($_GET["error"] == "emptycity") {
                        echo "<p class='text-center custom-error'>Miasto jest wymagane</p>";
                    } else if ($_GET["error"] == "stmtfailed") {
                        echo "<p class='text-center custom-error'>Something went wrong, try again!</p>";
                    } else if ($_GET["error"] == "none") {
                        echo "<p class='text-center custom-success'>Zmieniłeś dane konta</p>";
                    }
                }
                ?>
                <div class="form-group d-flex justify-content-center" id="change_data_account">
                    <form action="<?= baseUrl() . '/includes/manageaccount.inc.php' ?>" method="post">
                        <label>
                            <span>Imię</span>
                            <input class="form-control" type="text" name="firstname" placeholder="Imię"
                                   value="<?= $userdata['name'] ?>">
                        </label>
                        <label>
                            <span>Nazwisko</span>
                            <input class="form-control" type="text" name="lastname" placeholder="Nazwisko"
                                   value="<?= $userdata['surname'] ?>">
                        </label>

                        <label>
                            <span>E-mail</span>
                            <input class="form-control" type="text" name="email" placeholder="E-mail"
                                   value="<?= $userdata['email'] ?>">
                        </label>
                        <label>
                            <span>Twoje miasto</span>
                            <br>
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
                        </label>
                        <br>

                        <label>
                            <span>Twój opis</span>
                            <textarea class="form-control" type="text" name="description" placeholder="Twój opis" rows="10"><?= $userdata['description'] ?></textarea>
                        </label>

                        <button class="btn btn-success" type="submit" name="submit">Zmień dane</button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>
<?php require_once '../containers/footer.php'; ?>
