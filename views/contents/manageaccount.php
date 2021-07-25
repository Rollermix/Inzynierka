<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php
isLogged();
$sqli = "SELECT id FROM user WHERE login='".$_SESSION["useruid"]."'";
$result = mysqli_query($conn, $sqli);
$row = mysqli_fetch_array($result);
$_SESSION["idchanging"]=$row['id'];

?>
<section class="signup-form">
    <h2>
        Zmień dane konta
    </h2>
    <form action="<?= baseUrl() . '/includes/manageaccount.inc.php'?>" method="post">
        <input type = "text" name="firstname" placeholder="Wpisz imię...">
        <input type = "text" name="lastname" placeholder="Wpisz nazwisko...">
        <input type = "text" name="login" placeholder="Wpisz nazwę użytkownika...">
        <input type = "text" name="email" placeholder="Wpisz email...">
        <select name ='city'>
            <option>Wybierz miasto...</option>
            <?php
            $sqli = "SELECT name FROM city";
            $result = mysqli_query($conn, $sqli);
            while ($row = mysqli_fetch_array($result)) {

                echo '<option>'.$row['name'].'</option>';
            }
            ?>
        </select>
        <input type = "text" name="description" placeholder="Opisz siebie...">

        <button type = "submit" name ="submit">Zmień dane</button>
    </form>
</section>
    <form action="<?= baseUrl() . '/includes/changepassword.inc.php'?>" method="post">
        <input type ="password" name="newpassword" placeholder="Wpisz nowe hasło">
        <input type ="password" name="repeatnewpassword" placeholder="Powtórz nowe hasło">
        <input type ="password" name="password" placeholder="Wpisz obecne hasło">
        <button type = "submit" name ="submit2">Zmień hasło</button>
    </form>
<br>
<?php
echo '<button>' . '<a href ="'.baseUrl().'/includes/deleteaccount.inc.php?id=' . $_SESSION["idchanging"] . '">' . ' Usuń konto' . '</a>' . '</button>';
?>
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
        echo"<p>Wprowadziłeś zły email</p>";
    }
    else if($_GET["error"]=="logintaken")
    {
        echo"<p>Login zajęty</p>";
    }
    else if($_GET["error"]=="stmtfailed")
    {
        echo"<p>Something went wrong, try again!</p>";
    }
    else if($_GET["error"]=="none")
    {
        echo "<p>Zmieniłeś dane konta</p>";
    }
}
?>
<?php require_once '../containers/footer.php'; ?>
