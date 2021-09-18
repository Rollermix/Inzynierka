<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container custom-menu custom-container">
    <ul class="nav nav-tabs custom-tabs">
        <li class="nav-item active" role="presentation">
            <a class="nav-link active" href="profile.php" data-toggle="tab" role="tab" aria-selected="true">Wyświetl
                profil</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="manageaccount.php" role="tab">Edytuj dane konta</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="changepassword.php" role="tab">Zmień hasło</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" href="deleteaccount.php" role="tab">Usuń konto</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="container custom-container d-flex align-items-center flex-column" style="padding-top: 0">
            <?php
            if (isset($_SESSION["useruid"])) {
                $login = $_SESSION["userid"];
                $sqli = 'Select user.login, user.name,user.surname,user.email,dog.image_path,user.description,
       dog.size, dog.name AS dogname, dog.opis FROM user INNER JOIN dog ON user.id=dog.id_user WHERE user.id=?';
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sqli)) {
                    header("location: " . baseUrl() . "/views/contents/profile.php?error=stmtfailed");
                    exit();
                }
                mysqli_stmt_bind_param($stmt, "s", $login);

                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $name, $firstname, $lastname, $email, $imagepath, $userdescription, $size, $dogname, $dogdescription);
                while (mysqli_stmt_fetch($stmt)) {
                    echo '<h2 class="h2 text-center">Twój profil użytkownika</h2>';
                    echo '<br>';
                    echo "<div>";
                    echo $imagepath ?
                        "<img style='border-radius: 50%;' height=250 width=250 src='" . baseUrl() . '/includes/uploads/' . $imagepath . "'>"
                        :
                        "<img style='border-radius: 50%;' height=250 width=250 src='" . baseUrl() . '/assets/img/no_photo.jpg' . "'>";
                    echo "</div>";
                    echo "<div>";
                    echo "<h5 class='h5 text-center'>Imię psa: $dogname</h5>";
                    echo "</div>";
                    echo "<br>";
                    echo "<span class='text-left' style='width: 75%'>Opis psa</span>";
                    echo "<div style='width: 75%; border: 1px dashed black; padding: 10px'>";
                    echo "<div>$dogdescription</div>";
                    echo "<br>";
                    echo "<div><strong>Rozmiar psa: $size</strong></div>";
                    echo "</div>";
                    echo "<br>";
                    echo "<br>";
                    echo "<h2 class='h2 text-center'>Dane właściciela</h2>";
                    echo "<br>";
                    echo "<div class='d-flex align-items-start flex-column' style='width: 75%'>";
                    echo "<p class='h5 text-center'>Imię i nazwisko: $firstname $lastname</p>";
                    echo "<p class='h5 text-center'>Adres e-mail: <a href='mailto:$email'>$email</a></p>";
                    echo "<p class='h5 text-center'>Login: $name</p>";
                    echo "<span class='text-left' style='width: 75%'>Opis właściciela psa</span>";
                    echo "<div style='width: 100%; border: 1px dashed black; padding: 10px'>";
                    echo "<div>$userdescription</div>";
                    echo "<br>";
                    echo "</div>";
                }
                mysqli_stmt_close($stmt);
            }
            ?>
        </div>
    </div>
</div>
<?php require_once '../containers/footer.php'; ?>
