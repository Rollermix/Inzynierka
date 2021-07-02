<?php
function loginExists($conn, $login, $email)
{
    $sql = "SELECT * FROM user WHERE login = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$login, $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if($row=mysqli_fetch_assoc($resultData))
    {
        return $row;
    }
    else
    {
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}
function emptyInputLogin($login,$password)
{
    $result;
    if(empty($login) || empty($password))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function loginUser($conn,$login,$password)
{
    $uidExists = loginExists($conn, $login, $login);
    if($uidExists === false)
    {
        header("location: ../login.php?error=wrongLogin");
        exit();
    }
    $passwordHashed = $uidExists["password"];
    $checkPwd = password_verify($password,$passwordHashed);
    if($checkPwd === false)
    {
        header("location: ../login.php?error=wrongPassword");
    }
    else if ($checkPwd === true)
    {
        $sql =  "SELECT admin FROM user WHERE login = ?;";
        $stmt = $conn->prepare($sql);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
            header("location: ../admin/adminlogin.php?error=stmtfailed");
            exit();
        }
        $stmt->bind_param("s", $login);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = mysqli_fetch_row($result);
        if($row[0]== 1)
        {
            session_start();
            $_SESSION["userid"] = $uidExists["id"];
            $_SESSION["useruid"] = $uidExists["login"];
            $_SESSION['loggedin'] = true;
            header("location: ../adminindex.php");
            exit();
        }
        else if($row[0]==0)
        {
            header("location: ../adminlogin.php?error=notadmin");
            exit();
        }
    }
}
function emptyInputAdd($name)
{
    $result;
    if(empty($name))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function addcity($conn,$voivodshipid,$name,$description)
{
    if(empty($description))
    {
        $description="Nie dodano opisu miasta";
    }
    $sql="INSERT INTO city (name,description,id_voivodship) VALUES (?, ?, (SELECT id FROM voivodship where name = ?));";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../managecities.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss",$name,$description,$voivodshipid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managecities.php?error=none");
    exit();

}
function isLogged()
{

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo "Welcome to the member's area, " . $_SESSION['useruid'] . "!";
    } else {
        header("location: ../admin/adminlogin.php?error=notLogged");
        exit();
    }

}
function blockUser($conn,$name)
{
    $sql="UPDATE user SET blocked = 1 WHERE login=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../manageusers.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../manageusers.php?error=none");
    exit();
}
function unblockUser($conn,$name)
{
    $sql="UPDATE user SET blocked = 0 WHERE login=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../manageusers.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../manageusers.php?error=none");
    exit();
}
function deleteUser($conn,$name)
{
    $sql="UPDATE user SET deleted = 1 WHERE login=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../manageusers.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$name);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../manageusers.php?error=none");
    exit();
}
function addspot($conn, $city, $name, $description)
{
    if(empty($description))
    {
        $description="Nie dodano opisu miejsca";
    }
    $sql="INSERT INTO spot (name,description,id_city) VALUES (?, ?, (SELECT id FROM city where name = ?));";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../managespots.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss",$name,$description,$city);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managespots.php?error=none");
    exit();

}
function deleteSpot($conn,$name)
{
    {
        $sql="UPDATE spot SET deleted = 1 WHERE name=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
            header("location: ../managespots.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s",$name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../managespots.php?error=none");
        exit();
    }
}
function editspot($conn,$id, $city, $name, $description)
{
    $sql="UPDATE spot SET name =?, description=?, id_city = (SELECT id FROM city where name = ?) WHERE id=?";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../edit.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"ssss",$name,$description,$city,$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managespots.php?error=noneedit");
    exit();

}