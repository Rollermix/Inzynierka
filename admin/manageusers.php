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
                <a class="nav-link active" href="manageusers.php" data-toggle="tab" role="tab" aria-selected="true">Zarządzaj
                    użytkownikami</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" href="managespots.php" role="tab">Zarządzaj miejscami</a>
            </li>
        </ul>
        <section class="just-normal-form">
            <h2 class="h2 text-center">
                Zarządzaj użytkownikami
            </h2>
            <table class="table table-hover">
                <thead>
                <tr class="bg-dark">
                    <td style="width: 25%">Nazwa użytkownika</td>
                    <td style="width: 15%">Liczba upomnień</td>
                    <td style="width: 60%" class="text-center">Akcje</td>
                </tr>
                </thead>
                <tbody>
                <?php

                $sqli = "SELECT * FROM user WHERE admin = '0';";
                $result = mysqli_query($conn, $sqli);
                while ($row = mysqli_fetch_array($result)) {
                    $curr = $row['login'];
                    $sql = "SELECT id From reminder WHERE id_user=" . $row['id'];
                    $result2 = mysqli_query($conn, $sql);
                    $row2 = mysqli_num_rows($result2);
                    if ($row['blocked'] == 0 && $row['deleted'] == 0) {
                        echo "<tr>";
                        echo "<td>";
                        echo $row['login'];
                        echo "</td>";
                        echo "<td>";
                        echo $row2;
                        echo "</td>";
                        echo "<td>";
                        echo '<a class="btn btn-dark" href ="includes/manageusers.inc.php?block=' . $curr . '">' . 'Zablokuj' . '</a> ' .
                            '<a class="btn btn-dark" href ="includes/manageusers.inc.php?reporting=' . $curr . '">' . 'Zablokuj możliwość zgłaszania' . '</a> ' .
                            '<a class="btn btn-dark" href ="includes/manageusers.inc.php?delete=' . $curr . '">' . 'Usuń' . '</a>';
                        echo "</td>";

                        echo '</tr>';
                    } else if ($row['blocked'] == 2 && $row['deleted'] == 0) {
                        echo '<br>';
                        echo "<tr>";
                        echo "<td>";
                        echo $row['login'];
                        echo "</td>";
                        echo "<td>";
                        echo $row2;
                        echo "</td>";
                        echo "<td>";
                        echo '<a class="btn btn-dark" href ="includes/manageusers.inc.php?block=' . $curr . '">' . 'Zablokuj' . '</a> ' .
                            '<a class="btn btn-dark" href ="includes/manageusers.inc.php?unblockreporting=' . $curr . '">' . 'Odblokuj możliwość zgłaszania' . '</a> ' .
                            '<a class="btn btn-dark" href ="includes/manageusers.inc.php?delete=' . $curr . '">' . 'Usuń' . '</a>';
                        echo "</td>";

                        echo '</tr>';
                    } else if ($row['blocked'] == 1 && $row['deleted'] == 0) {
                        echo '<br>';
                        echo "<tr>";
                        echo "<td>";
                        echo $row['login'];
                        echo "</td>";
                        echo "<td>";
                        echo $row2;
                        echo "</td>";
                        echo "<td>";
                        echo '<a class="btn btn-dark" href ="includes/manageusers.inc.php?unblock=' . $curr . '">' . 'Odblokuj' . '</a> ' .
                            '<a class="btn btn-dark" href ="includes/manageusers.inc.php?delete=' . $curr . '">' . 'Usuń' . '</a>';
                        echo "</td>";
                    }
                }
                ?>
                </tbody>
            </table>
        </section>
    </div>
<?php require_once '../views/containers/footer.php'; ?>