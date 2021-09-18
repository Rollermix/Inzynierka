<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<?php
canViewAsAdmin($conn);
?>
<div class="container custom-menu">
    <ul class="nav nav-tabs custom-tabs">
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="suggestions.php" role="tab">Zarządzaj sugestiami</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="managenotification.php" role="tab">Zarządzaj zgłoszeniami</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="managecities.php" role="tab">Zarządzaj miastami</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="manageusers.php" role="tab">Zarządzaj użytkownikami</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="managespots.php" role="tab">Zarządzaj miejscami</a>
        </li>
    </ul>
</div>

<?php require_once '../views/containers/footer.php'; ?>