<nav class="navbar sticky-top navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="<?= baseUrl() . '/views/contents/main.php'?>">DoggoWalks</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
    <div class="navbar-nav">
        <?php
        if (isset($_SESSION["useruid"])) {
            echo "<div class='system'>";
                echo "<div class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/views/contents/about.php'>O projekcie</a>";
                echo "</div>";
            if($messagesCount = hasUnreadMessages($conn, $_SESSION["userid"])) {
                echo "<div class='nav-item d-flex flex-row'>";
                    echo "<div data-icon='&#xe021;' class='icon nav-link'>";
                    echo "<a class='nav-link' href='#'></div> Nieprzeczytane wiadomości (".$messagesCount. ")</a>";
                echo "</div>";
            } else {
                echo "<div class='nav-item d-flex flex-row'>";
                    echo "<div data-icon='`' class='icon nav-link'></div>";
                    echo "<a class='nav-link' href='#'>Nie masz nowych wiadomości.</a>";
                echo "</div>";
            }
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
                echo "<div class='nav-item'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/views/contents/manageaccount.php'>Zarządzaj profilem</a>";
                echo "</div>";
                if(isAdmin($conn, $_SESSION['useruid'])) {
                    echo "<div class='nav-item'>";
                        echo "<a class='nav-link' href='". baseUrl() ."/admin/admin.php'>Administracja</a>";
                    echo "</div>";
                }
                echo "<a class='nav-item d-flex flex-row'>";
                    echo "<a class='nav-link' href='". baseUrl() ."/includes/logout.inc.php'>Wyloguj się</a>";
                    echo "<div data-icon='&#xe036;' class='icon nav-link no-padding-left-right'>";
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
