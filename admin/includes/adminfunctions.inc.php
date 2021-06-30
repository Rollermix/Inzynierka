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