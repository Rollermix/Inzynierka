<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Praca inżynierska-logowanie</title>
</head>
<body>
<?php
require_once 'adminheader.php';
require_once 'includes/dbh.inc.php';
require_once 'includes/adminfunctions.inc.php';
isLogged();
?>
<section class="city-form">
    <h2>
        Zarządzaj użytkownikami
    </h2>
                <?php

                $sqli = "SELECT * FROM user WHERE admin = '0';";
                $result = mysqli_query($conn, $sqli);
                while ($row = mysqli_fetch_array($result)) {
                    $curr=$row['login'];
                    if ($row['blocked']==0 && $row['deleted']==0) {
                        echo $row['login'] . '<button>' . '<a href ="includes/manageusers.inc.php?block=' . $curr . '">' . ' Zablokuj' . '</a>' .
                            '</button>' . '<button>' . '<a href ="includes/manageusers.inc.php?delete=' . $curr . '">' . ' Usun' . '</a>' . '</button>';
                        echo '<br>';
                    }
                    else if ($row['blocked']==1 && $row['deleted']==0) {
                        echo $row['login'] . '<button>' . '<a href ="includes/manageusers.inc.php?unblock=' . $curr . '">' . ' Odblokuj' . '</a>' . '</button>' .
                            '</button>' . '<button>' . '<a href ="includes/manageusers.inc.php?delete=' . $curr . '">' . ' Usun' . '</a>' . '</button>';
                        echo '<br>';
                    }
                }
?>
</section>

</body>
</html>