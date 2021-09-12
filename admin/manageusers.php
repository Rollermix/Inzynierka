<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
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
                <a class="nav-link" href="managecities.php" role="tab">Dodaj
                    miasto</a>
            </li>
            <li class="nav-item active" role="presentation">
                <a class="nav-link active" href="manageusers.php" data-toggle="tab" role="tab" aria-selected="true">Zarządzaj użytkownikami</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="managespots.php" role="tab">Zarządzaj miejscami</a>
            </li>
        </ul>
        <section class="city-form">
            <h2>
                Zarządzaj użytkownikami
            </h2>
            <?php

            $sqli = "SELECT * FROM user WHERE admin = '0';";
            $result = mysqli_query($conn, $sqli);
            while ($row = mysqli_fetch_array($result)) {
                $curr = $row['login'];
                $sql = "SELECT id From reminder WHERE id_user=" . $row['id'];
                $result2 = mysqli_query($conn, $sql);
                $row2 = mysqli_num_rows($result2);
                if ($row['blocked'] == 0 && $row['deleted'] == 0) {
                    echo $row['login'] . '<button>' . '<a href ="includes/manageusers.inc.php?block=' . $curr . '">' . ' Zablokuj' . '</a>' .
                        '</button>' . '<button>' . '<a href ="includes/manageusers.inc.php?reporting=' . $curr . '">' . ' Zablokuj możliwość zgłaszania' . '</a>' .
                        '</button>' . '<button>' . '<a href ="includes/manageusers.inc.php?delete=' . $curr . '">' . ' Usun' . '</a>' . '</button>';
                    echo ' Użytkownik dostał następującą liczbę upomnień: ' . $row2;
                    echo '<br>';
                } else if ($row['blocked'] == 2 && $row['deleted'] == 0) {
                    echo $row['login'] . '<button>' . '<a href ="includes/manageusers.inc.php?block=' . $curr . '">' . ' Zablokuj' . '</a>' .
                        '</button>' . '<button>' . '<a href ="includes/manageusers.inc.php?unblockreporting=' . $curr . '">' . ' Odblokuj możliwość zgłaszania' . '</a>' .
                        '</button>' . '<button>' . '<a href ="includes/manageusers.inc.php?delete=' . $curr . '">' . ' Usun' . '</a>' . '</button>';
                    echo ' Użytkownik dostał następującą liczbę upomnień: ' . $row2;
                    echo '<br>';
                } else if ($row['blocked'] == 1 && $row['deleted'] == 0) {
                    echo $row['login'] . '<button>' . '<a href ="includes/manageusers.inc.php?unblock=' . $curr . '">' . ' Odblokuj' . '</a>' . '</button>' .
                        '</button>' . '<button>' . '<a href ="includes/manageusers.inc.php?delete=' . $curr . '">' . ' Usun' . '</a>' . '</button>';
                    echo '<br>';
                }
            }
            ?>
        </section>
    </div>
<?php require_once '../views/containers/footer.php'; ?>