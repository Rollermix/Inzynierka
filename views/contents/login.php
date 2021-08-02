<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
    <div class="container">
        <div class="form-group d-flex justify-content-center">
            <form action="<?= baseUrl() . '/includes/login.inc.php'?>" method="post">
            <h2>Zaloguj się</h2>
                <label for="username">Nazwa użytkownika</label>
                <input class="form-control" type="text" name="name" id="username" placeholder="Wpisz nazwę użytkownika lub email...">

                <label for="password">Hasło</label>
                <input class="form-control" type="password" name="password" id="password" placeholder="Wpisz hasło...">

                <div class="buttons d-flex justify-content-between">
                    <button class="btn btn-success" type = "submit" name ="submit">Zaloguj się</button>
                    <button class="btn btn-dark" type = "submit" name ="submit2">Przypomnij hasło</button>
                </div>
            </form>
        </div>
    </div>
    <?php
    if(isset($_GET["error"]))
    {
        switch($_GET["error"]) {
            case "emptyinput":
                echo "<p>Wypełnij wszystkie pola!</p>";
                break;
            case "wronglogin": 
                echo "<p>Niepoprawny login!</p>";
                break;
            case "wrongPassword": 
                echo "<p>Niepoprawne hasło!</p>";
                break;
            case "stmtfailed":
                echo "<p>Błąd podczas logowania, proszę zwróć się do administratora o pomoc.</p>";
                break;
            case "notLogged":
                echo "<p>Brak dostępu, zaloguj się aby uzyskać dostęp!</p>";
                break;
            case "accountblocked": 
                echo "<p>Konto zablokowane. Jeżeli uważasz, że to błąd, zwróć się proszę do administratora.</p>";
                break;
            case "accountblocked": 
                echo "<p>Konto usunięte!</p>";
                break;
            case "none": 
                echo "<p>Zalogowałeś się!</p>";
            case "remindnone":
                echo "<p>Hasło zostało wysłane na maila!</p>";
            default:
                echo "<p>Nieznany błąd, proszę zwróc się do administratora o pomoc.";
        }
    }
    ?>
<?php require_once '../containers/footer.php'; ?>
