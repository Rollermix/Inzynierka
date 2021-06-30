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
?>
<section class="city-form">
    <h2>
        Zarządzaj użytkownikami
    </h2>

                <?php

                $sqli = "SELECT * FROM user WHERE admin = '0';";
                $result = mysqli_query($conn, $sqli);
                while ($row = mysqli_fetch_array($result)) {
                    if ($row['blocked']==0)
                        echo $row['login'].' Zablokuj'. ' Usuń';
                    else if ($row['blocked']==1)
                        echo $row['login'].' Odblokuj'. ' Usuń';
                }
                ?>

</section>

</body>
</html>