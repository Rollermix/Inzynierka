<nav class="navbar sticky-top navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="about.php">O DoggoWalks</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <?php
        if (isset($_SESSION["useruid"])) {
            if($messagesCount = hasUnreadMessages($conn, $_SESSION["userid"])) {
                echo "<li class='nav-item'>";
                    echo "<a class='nav-link' href='#'>Nieprzeczytane wiadomości (".$messagesCount. ")</a>";
                echo "</li>";
            } else {
                echo "<li class='nav-item'>";
                    echo "<a class='nav-link' href='#'>Nie masz nowych wiadomości.</a>";
                echo "</li>";
            }
            if(hasDog($conn, $_SESSION["userid"])) {
                echo "<li class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/views/contents/editdog.php'>Edytuj Psa</a>";
                echo "</li>";
            } else {
                echo "<li class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/views/contents/adddog.php'>Dodaj Psa</a>";
                echo "</li>";
            }

            echo "<li class='nav-item'>";
                echo "<a class='nav-link' href='". baseUrl() ."/views/contents/suggestion.php'>Zgłoszenia i sugestie</a>";
            echo "</li>";

            echo "<li class='nav-item'>";
                echo "<a class='nav-link' href='". baseUrl() ."/views/contents/managewalk.php'>Zarządzaj spacerami</a>";
            echo "</li>";

            echo "<li class='nav-item'>";
                echo "<a class='nav-link' href='". baseUrl() ."/views/contents/manageaccount.php'>Zarządzaj profilem</a>";
            echo "</li>";

            echo "<li class='nav-item'>";
                echo "<a class='nav-link' href='". baseUrl() ."/includes/logout.inc.php'>Wyloguj się</a>";
            echo "</li>";

        } else {
            echo "<li class='nav-item'>";
                echo "<a class='nav-link' href='". baseUrl() ."/views/contents/signup.php'>Zarejestruj się</a>";
            echo "</li>";
            echo "<li class='nav-item'>";
                echo "<a class='nav-link' href='". baseUrl() ."/views/contents/login.php'>Zaloguj się</a>";
            echo "</li>";
        }
    ?>
    </ul>
</nav>
