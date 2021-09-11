<nav class="navbar sticky-top navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="<?= baseUrl() . '/views/contents/start.php'?>">DoggoWalks</a>
    <button class="custom-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <div class="navbar-nav custom-navbar">
        <?php
        if (isset($_SESSION["useruid"])) {
            echo "<div class='system'>";
                echo "<div class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/views/contents/about.php'>O projekcie</a>";
                echo "</div>";
                echo "<div class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/views/contents/suggestion.php'>Zgłoszenia i sugestie</a>";
                echo "</div>";
            echo "</div>";
            echo "<div class='dogs'>";
            if(hasDog($conn, $_SESSION["userid"])) {
                echo "<div class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/views/contents/editdog.php'>Edytuj Psa</a>";
                echo "</div>";
            } else {
                echo "<div class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/views/contents/adddog.php'>Dodaj Psa</a>";
                echo "</div>";
            }
                echo "<div class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/views/contents/managewalk.php'>Zarządzaj spacerami</a>";
                echo "</div>";
            echo "</div>";
            echo "<div class='account'>";
                if(isAdmin($conn, $_SESSION['useruid'])) {
                    echo "<div class='nav-item'>";
                        echo "<a class='nav-link' href='". baseUrl() ."/admin/suggestions.php'>Administracja</a>";
                    echo "</div>";
                }
                echo "<div class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/views/contents/manageaccount.php'>Zarządzaj profilem</a>";
                echo "</div>";
                if($messagesCount = hasUnreadMessages($conn, $_SESSION["userid"])) {
                    echo "<div class='nav-item'>";
                        echo "<a class='nav-link' href='#'>✉ Wiadomości (".$messagesCount. ")</a>";
                    echo "</div>";
                } else {
                    echo "<div class='nav-item'>";
                        echo "<a class='nav-link' href='#'>Wiadomości (0)</a>";
                    echo "</div>";
                }
                echo "<div class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/includes/logout.inc.php'>Wyloguj się</a>";
                echo "</div>";
            echo "</div>";

        } else {
            echo "<div class='nav-item'>";
                echo "<a class='nav-link' href='". baseUrl() ."/views/contents/about.php'>O projekcie</a>";
            echo "</div>";
            echo "<div class='nav-item'>";
                echo "<a class='nav-link' href='". baseUrl() ."/views/contents/signup.php'>Zarejestruj się</a>";
            echo "</div>";
            echo "<div class='nav-item'>";
                echo "<a class='nav-link' href='". baseUrl() ."/views/contents/login.php'>Zaloguj się</a>";
            echo "</div>";
        }
    ?>
    </ul>
</nav>
<div class="triangle-background"></div>