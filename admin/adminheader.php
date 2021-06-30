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
            echo  "<li><a href='signup.php'>Profil</a></li>";
            echo  "<li><a href='addcity.php'>Dodaj miasto</a></li>";
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