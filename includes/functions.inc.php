<?php
function emptyInputSignup($firstname,$lastname,$login,$email,$password,$repeatpassword)
{
    $result;
    if(empty($firstname) || empty($lastname) || empty($login) || empty($email) || empty($password) || empty($repeatpassword))
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

    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
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

function createUser($conn,$firstname,$lastname,$login,$email,$description,$password,$city)
{
    if($city=="Wybierz miasto...")
        $city=NULL;
    $sql = "INSERT INTO user (name,surname,login,email,description,password,id_city) VALUES (?,?,?,?,?,?,(SELECT id FROM city where name = ?));";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssssss",$firstname,$lastname,$login,$email,$description,$hashedPwd,$city);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();
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
        session_start();
        $_SESSION["userid"] = $uidExists["id"];
        $_SESSION["useruid"] = $uidExists["login"];
        $_SESSION['loggedin'] = true;
        header("location: ../index.php");
        exit();
    }
}
function isLogged()
{

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo "Welcome to the member's area, " . $_SESSION['useruid'] . "!";
    } else {
        header("location: ../login.php?error=notLogged");
        exit();
    }

}
function isBlocked($conn,$login)
{
    $result=false;
    $sql = "SELECT blocked FROM user WHERE login = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$login, $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($resultData);
    if($row['blocked']==1)
    {
        $result = true;
    }
    else
    {
        $result = false;

    }
    return $result;
    mysqli_stmt_close($stmt);
}
function isDeleted($conn,$login)
{
    $result;
    $sql = "SELECT deleted FROM user WHERE login = ? OR email = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$login, $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($resultData);
    if($row['deleted']==1)
    {
        $result = true;
    }
    else
    {
        $result = false;

    }
    return $result;
    mysqli_stmt_close($stmt);
}
function editUser($conn,$firstname,$lastname,$login,$email,$description,$city,$id)
{

    $sql="UPDATE `user` SET `description`=IFNULL(Null,`description`) WHERE id =?";
}