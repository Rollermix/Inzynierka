<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
            echo  "<li><a href='suggestions.php'>Zarządzaj sugestiami</a></li>";
            echo  "<li><a href='managenotification.php'>Zarządzaj zgłoszeniami</a></li>";
            echo "<li><a href='managecities.php'>Dodaj miasto</a></li>";
            echo  "<li><a href='manageusers.php'>Zarządzaj użytkownikami</a></li>";
            echo  "<li><a href='managespots.php'>Zarządzaj miejscami</a></li>";
            echo  "<li><a href='includes/adminlogout.inc.php'>Wyloguj sie</a></li>";
?>
<?php require_once '../views/containers/footer.php'; ?>