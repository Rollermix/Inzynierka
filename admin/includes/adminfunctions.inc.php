<?php

function loginAdminUser($conn,$login,$password)
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
function editcity($conn,$id, $voivodship, $name, $description)
{
    $sql="UPDATE city SET name =?, description=?, id_voivodship = (SELECT id FROM voivodship where name = ?) WHERE id=?;";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../editcity.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"ssss",$name,$description,$voivodship,$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managecities.php?error=updated");
    exit();

}
function deleteCity($conn,$nazwa)
{
    $sql="UPDATE city SET deleted =1 WHERE name=?;";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../managecities.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt,"s",$nazwa);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managecities.php?error=deleted");
    exit();
}
function discardSuggestion($conn, $id)
{
    $sql="UPDATE suggestions SET id_status = 4 WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../suggestions.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../suggestions.php?error=none");
    exit();
}
function readSuggestion($id,$conn)
{
    $sql="UPDATE suggestions SET id_status = 2 WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../admin/suggestions.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    exit();
}
function sendReminder($conn,$adminid,$id,$description)
{
    if(empty($description))
    {
        header("location: ../reminduser.php?error=nothing&iduser=".$id);
        exit();
    }
    $sql="INSERT INTO reminder (id_user,id_sending_user,Message) VALUES (?,?,?);";
    $stmt=mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../reminduser.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss",$id,$adminid,$description);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../manageusers.php?error=none");
    exit();
}
function acceptSuggestion($id,$conn)
{
    $sql = "UPDATE suggestions SET id_status = 3 WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../admin/suggestions.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function readNotofication($conn,$id)
{
    $sql="UPDATE notification SET id_status = 2 WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../admin/suggestions.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    exit();
}
function acceptnotification($conn,$id,$iduser)
{
    $sql="UPDATE notification SET id_status = 3 WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../admin/managenotification.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../reminduser.php?iduser=".$iduser);
    exit();

}
function denynotification($conn,$id)
{
    $sql="UPDATE notification SET id_status = 4 WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../managenotification.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managenotification.php?");
    exit();
}
function blockreporting($conn,$nazwa)
{
    $sql="UPDATE user SET blocked = 2 WHERE login=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../manageusers.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$nazwa);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../manageusers.php?error=none");
    exit();
}
function unblockreporting($conn,$nazwa)
{
    $sql="UPDATE user SET blocked = 0 WHERE login=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../manageusers.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$nazwa);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../manageusers.php?error=none");
    exit();
}