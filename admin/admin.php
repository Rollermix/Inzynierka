<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>

<div class="admin-menu">
    <ul>
    <?php
        echo "<li><a href='suggestions.php'>Zarządzaj sugestiami</a></li>";
        echo "<li><a href='managenotification.php'>Zarządzaj zgłoszeniami</a></li>";
        echo "<li><a href='managecities.php'>Dodaj miasto</a></li>";
        echo "<li><a href='manageusers.php'>Zarządzaj użytkownikami</a></li>";
        echo "<li><a href='managespots.php'>Zarządzaj miejscami</a></li>";
    ?>
    </ul>
</div>

<?php require_once '../views/containers/footer.php'; ?>