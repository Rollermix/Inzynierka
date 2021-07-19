<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
<nav>
    <ul>

        <?php
        if (isset($_SESSION["useruid"]))
        {
            echo  "<li><a href='suggestions.php'>Zarządzaj sugestiami</a></li>";
            echo  "<li><a href='managenotification.php'>Zarządzaj zgłoszeniami</a></li>";
            echo "<li><a href='managecities.php'>Dodaj miasto</a></li>";
            echo  "<li><a href='manageusers.php'>Zarządzaj użytkownikami</a></li>";
            echo  "<li><a href='managespots.php'>Zarządzaj miejscami</a></li>";
            echo  "<li><a href='includes/adminlogout.inc.php'>Wyloguj sie</a></li>";

        }
        else
        {
            echo "<li><a href='adminlogin.php'>Zaloguj się</a></li>";
        }

        ?>


    </ul>
</nav>
</body>
</html>