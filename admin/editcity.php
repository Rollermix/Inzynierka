<?php require_once '../views/containers/header.php'; ?>
<?php require_once '../views/containers/menu.php'; ?>
<?php
require_once 'includes/adminfunctions.inc.php';
require_once 'includes/dbh.inc.php';
?>
<form action="includes/editcity.inc.php" method="post">
    <?php
    if(isset($_GET["edit"])) {
        $nazwa = ($_GET["edit"]);
        $sql="Select id,id_voivodship,description From city Where name= ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
            header("location: ../managecities.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s",$nazwa);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $rowid = mysqli_fetch_array($resultData);
        $id=$rowid['id_voivodship'];
        $sql2="SELECT voivodship.name From voivodship Inner Join city ON city.id_voivodship=voivodship.id where city.id_voivodship=?;";
        $stmt2 = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt2,$sql2))
        {
            header("location: ../managecities.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt2, "s",$id);
        mysqli_stmt_execute($stmt2);
        $resultData2 = mysqli_stmt_get_result($stmt2);
        $rowvoidvoship = mysqli_fetch_array($resultData2);
        $voivodship = $rowvoidvoship['name'];
        echo '<select name ="voivodship">'.'<option>'.$voivodship.'</option>';
        $sqli = "SELECT name FROM voivodship";
        $result = mysqli_query($conn, $sqli);
        while ($row = mysqli_fetch_array($result)) {
            if($voivodship !== $row['name'])
                echo '<option>' . $row['name'] . '</option>';
        }
        echo '</select>';

        echo '<input type = "text" name="name" value="'.$nazwa.'">';

        $description = $rowid['description'];
        $_SESSION['idcity'] = $rowid['id'];
        echo '<input type = "text" name="description" value="'.$description.'">';
        echo '<br >';

    }

    ?>
    <button type = "submit" name ="submit">Edytuj</button>
</form>
<?php require_once '../views/containers/footer.php'; ?>