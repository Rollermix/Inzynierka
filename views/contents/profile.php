<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php
if(isset($_GET["login"])) {
    $login = $_GET["login"];
    $sqli = 'Select user.login, user.name,user.surname,user.email,dog.image_path,user.description,
       dog.size, dog.name AS dogname, dog.opis FROM user INNER JOIN dog ON user.id=dog.id_user WHERE user.login=?';
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sqli)) {
        header("location: " . baseUrl() . "/views/contents/profile.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$login);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_bind_result($stmt, $name, $firstname,$lastname,$email,$imagepath,$userdescription,$size,$dogname,$dogdescription);
    while (mysqli_stmt_fetch($stmt)) {
        if($imagepath==NULL)
            $imagepath="Nie dodano zdjęcia";
        printf ("Nazwa użytkownika:%s <br> Imie:%s<br> Nazwisko:%s <br> Email:%s <br> Opis Użytkownika:%s <br>
                Rozmiar psa:%s <br> Pupil wabi sie: %s <br> Opis psa: %s <br> Zdjęcie:%s",
            $name,$firstname,$lastname,$email,$userdescription,$size,$dogname,$dogdescription,$imagepath);
    }
    mysqli_stmt_close($stmt);
}
?>
<?php require_once '../containers/footer.php'; ?>
