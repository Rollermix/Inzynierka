<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Praca inżynierska-logowanie</title>
</head>
<body>
<?php
require_once 'adminheader.php';
require_once 'includes/dbh.inc.php';
isLogged();
?>

<form action="includes/editspot.inc.php" method="post">
<?php
if(isset($_GET["edit"])) {
    $nazwa = ($_GET["edit"]);
    $sql="Select id,id_city,description From spot Where name= ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../managespots.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$nazwa);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $rowid = mysqli_fetch_array($resultData);
    $id=$rowid['id_city'];
    $sql2="SELECT city.name From city Inner Join spot ON spot.id_city=city.id where spot.id_city=?;";
    $stmt2 = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt2,$sql2))
    {
        header("location: ../managespots.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt2, "s",$id);
    mysqli_stmt_execute($stmt2);
    $resultData2 = mysqli_stmt_get_result($stmt2);
    $rowcity = mysqli_fetch_array($resultData2);
    $city = $rowcity['name'];
    echo '<select name ="city">'.'<option>'.$city.'</option>';
            $sqli = "SELECT name,deleted FROM city";
            $result = mysqli_query($conn, $sqli);
            while ($row = mysqli_fetch_array($result)) {
                if($city !== $row['name'] && $row['deleted']==0) {
                    echo '<option>' . $row['name'] . '</option>';
                }
            }
    echo '</select>';

        echo '<input type = "text" name="name" value="'.$nazwa.'">';

    $description = $rowid['description'];
    $_SESSION['idspot'] = $rowid['id'];

    echo '<input type = "text" name="description" value="'.$description.'">';
        echo '<br >';

}

?>
    <button type = "submit" name ="submit">Edytuj</button>
</form>
</body>
</html>
