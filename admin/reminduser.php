<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<section class="city-form">
    <h2>
        Zarządzaj użytkownikami
    </h2>
    <?php
    $_SESSION["reported"] = $_GET["iduser"];
    ?>
        <form action="includes/reminduser.inc.php" method="post">
        <input type = "text" name="description" placeholder="Dodaj krótki opis...">
        <button type = "submit" name ="submit"><a href="includes/reminduser.inc.php">Wyślij upomnienie</a></button>

        </form>


</section>
<?php require_once '../views/containers/footer.php'; ?>