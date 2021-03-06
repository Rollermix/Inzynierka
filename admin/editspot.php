<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<?php
canViewAsAdmin($conn);
?>
<div class="container custom-container">
    <h2 class="h2 text-center">Edytuj spot</h2>
    <br>
    <form action="includes/editspot.inc.php" method="post" class="just-normal-form">
        <?php
        if (isset($_GET["edit"])) {
            $nazwa = ($_GET["edit"]);
            $sql = "Select id,id_city,description From spot Where name= ?;";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("location: ../managespots.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "s", $nazwa);
            mysqli_stmt_execute($stmt);
            $resultData = mysqli_stmt_get_result($stmt);
            $rowid = mysqli_fetch_array($resultData);
            $id = $rowid['id_city'];
            $sql2 = "SELECT city.name From city Inner Join spot ON spot.id_city=city.id where spot.id_city=?;";
            $stmt2 = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt2, $sql2)) {
                header("location: ../managespots.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt2, "s", $id);
            mysqli_stmt_execute($stmt2);
            $resultData2 = mysqli_stmt_get_result($stmt2);
            $rowcity = mysqli_fetch_array($resultData2);
            $city = $rowcity['name'];
            echo "<label>";
            echo '<select class="custom-select" name ="city">' . '<option>' . $city . '</option>';
            $sqli = "SELECT name,deleted FROM city";
            $result = mysqli_query($conn, $sqli);
            while ($row = mysqli_fetch_array($result)) {
                if ($city !== $row['name'] && $row['deleted'] == 0) {
                    echo '<option>' . $row['name'] . '</option>';
                }
            }
            echo '</select>';
            echo "</label>";

            echo "<label>";
            echo '<input class="form-control" type = "text" name="name" value="' . $nazwa . '">';
            echo "</label>";
            $description = $rowid['description'];
            $_SESSION['idspot'] = $rowid['id'];

            echo "<label>";
            echo '<input class="form-control" type = "text" name="description" value="' . $description . '">';
            echo "</label>";


        }

        ?>
        <button class="btn btn-dark" type="submit" name="submit">Edytuj</button>
    </form>
</div>
<?php require_once '../views/containers/footer.php'; ?>
