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