<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<?php
canViewAsAdmin($conn);
?>
    <div class="container custom-container">
        <h2 class="h2 text-center">
            Zarządzaj użytkownikami
        </h2>
        <?php
        $_SESSION["reported"] = $_GET["iduser"];
        ?>
        <form action="includes/reminduser.inc.php" method="post" class="just-normal-form">
            <p>Upominany użytkownik: <?= getUsernameById($conn, $_GET["iduser"])[0] ?></p>
            <label>
                <textarea rows=8 class="form-control" type="text" name="description"
                          placeholder="Krótki opis powodu upomnienia"></textarea>
            </label>
            <button class="btn btn-dark" type="submit" name="submit">Wyślij upomnienie</button>

        </form>
    </div>
<?php require_once '../views/containers/footer.php'; ?>