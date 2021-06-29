<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Praca inżynierska-logowanie</title>
</head>
<body>
    <section class="signup-form">
        <h2>
            Zarejestruj się
        </h2>
        <form action="includes/signup.inc.php" method="post">
            <input type = "text" name="firstname" placeholder="Wpisz imię...">
            <input type = "text" name="lastname" placeholder="Wpisz nazwisko...">
            <input type = "text" name="login" placeholder="Wpisz nazwę użytkownika...">
            <input type = "text" name="email" placeholder="Wpisz email...">
            <input type = "text" name="description" placeholder="Opisz siebie...">
            <input type = "password" name="password" placeholder="Wpisz hasło...">
            <input type = "password" name="repeatpassword" placeholder="Powtórz hasło...">
            <button type = "submit" name ="submit">Zarejestruj się</button>
        </form>
    </section>
    <?php
    if(isset($_GET["error"]))
    {
        if($_GET["error"]=="emptyinput")
        {
            echo"<p>Wypełnij wszystkie pola!</p>";
        }
        else if($_GET["error"]=="invalidlogin")
        {
            echo"<p>Niepoprawny login!</p>";
        }
        else if($_GET["error"]=="passworddontmatch")
        {
            echo"<p>Wprowadziłeś różne hasła</p>";
        }
        else if($_GET["error"]=="invalidemail")
        {
            echo"<p>Wprowadziłeś różne hasła</p>";
        }
        else if($_GET["error"]=="logintaken")
        {
            echo"<p>Login zajęty</p>";
        }
        else if($_GET["error"]=="stmtfailed")
        {
            echo"<p>Something went wrong, try again!</p>";
        }
    }
    ?>
</body>
</html>
