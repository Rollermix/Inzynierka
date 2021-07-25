<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="assets/css/normalize.css">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/main.css">
    </head>
    <body>
        <nav>
            <ul>
                    <li><a href='about.php'>O DoggoWalks</a></li>
                    <?php
                    require_once 'includes/functions.inc.php';
                    require_once 'includes/dbh.inc.php';
                    if (isset($_SESSION["useruid"]))
                    {
                        hasunreadMessage($conn,$_SESSION["userid"]);
                        echo '<br>';
                        hasdog($conn,$_SESSION["userid"]);
                        echo  "<li><a href='suggestion.php'>Zgłoszenia i sugestie</a></li>";
                        echo  "<li><a href='managewalk.php'>Zarządzaj spacerami</a></li>";
                        echo  "<li><a href='manageaccount.php'>Zarządzaj profilem</a></li>";
                        echo  "<li><a href='includes/logout.inc.php'>Wyloguj sie</a></li>";
                    }
                    else
                    {
                        echo "<li><a href='signup.php'>Zarejestruj się</a></li>";
                        echo "<li><a href='login.php'>Zaloguj się</a></li>";
                    }

                    ?>


            </ul>
        </nav>
    </body>
</html>