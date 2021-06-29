<?php
function emptyInputSignup($firstname,$lastname,$login,$email,$description,$password,$repeatpassword)
{
    $result;
    if(empty($firstname) || empty($lastname) || empty($login) || empty($email) || empty($description) || empty($password) || empty($repeatpassword))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}

function invalidLogin($login)
{
    $result;
    if(!preg_match("/^[a-zA-Z0-9]+$/",$login))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}

function invalidEmail($email)
{
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return result;
}

function pwdMatch($password, $repeatpassword)
{
    $result;
    if ($password!==$repeatpassword)
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}

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

function createUser($conn,$firstname,$lastname,$login,$email,$description,$password)
{
    $sql = "INSERT INTO user (name,surname,login,email,description,password) VALUES (?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssssss",$firstname,$lastname,$login,$email,$description,$hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
}
