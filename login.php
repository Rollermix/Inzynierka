
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Praca inżynierska-logowanie</title>
</head>
<body>
<?php
require_once 'header.php';
?>
    <section class="login-form">
        <h2>
            Zaloguj się
        </h2>
        <form action="includes/login.inc.php" method="post">
            <input type = "text" name="name" placeholder="Wpisz nazwę użytkownika lub email...">
            <input type = "password" name="password" placeholder="Wpisz hasło...">
            <button type = "submit" name ="submit">Zaloguj się</button>
            <button type = "submit" name ="submit2">Przypomnij hasło</button>
        </form>
    </section>
    <?php
    if(isset($_GET["error"]))
    {
        if($_GET["error"]=="emptyinput")
        {
            echo"<p>Wypełnij wszystkie pola!</p>";
        }
        else if($_GET["error"]=="wronglogin")
        {
            echo"<p>Niepoprawny login!</p>";
        }
        else if($_GET["error"]=="wrongPassword")
        {
            echo"<p>Niepoprawne hasło!</p>";
        }

        else if($_GET["error"]=="stmtfailed")
        {
            echo"<p>Something went wrong, try again!</p>";
        }
        else if($_GET["error"]=="notLogged")
        {
            echo"<p>Brak dostępu, zaloguj się aby uzyskać dostęp!</p>";
        }
        else if($_GET["error"]=="accountblocked")
        {
            echo"<p>Koncto zablokowane</p>";
        }else if($_GET["error"]=="accountdeleted")
        {
            echo"<p>Konto usunięte</p>";
        }
        else if($_GET["error"]=="none")
        {
            echo "<p>Zalogowałeś sie</p>";
        }

    }
    ?>
</body>
</html>