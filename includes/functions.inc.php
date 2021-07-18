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
function loginExists2($conn, $login)
{
    $sql = "SELECT * FROM user WHERE login =? or email=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$login,$login);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    if(mysqli_fetch_assoc($resultData))
    {
        $result = true;
        return $result;
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

    $sql="UPDATE user SET 
                name=IFNULL(?,name),
                surname=IFNULL(?,surname),
                email=IFNULL(?,email),
                login=IFNULL(?,login),
                description=IFNULL(?,description),
                id_city=IFNULL((SELECT id FROM city where name = ?),id_city)
                WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../manageaccount.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssssss",$firstname,$lastname,$email,$login,$description,$city,$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../manageaccount.php?error=none");
    exit();
}
function deleteAccount($conn,$id)
{
    $sql="UPDATE user SET 
                deleted = 1
                WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../manageaccount.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header ("location: ../includes/logout.inc.php?deleted=true");
    exit();
}
function emptyInputChangingPwd($password,$newpassword,$repeatnewpassword)
{
    $result;
    if(empty($password) || empty($newpassword) || empty($repeatnewpassword))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function editPwd($conn,$login,$password,$newpassword,$repeatnewpassword)
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
    else
    {
        $hashedPwd = password_hash($newpassword, PASSWORD_DEFAULT);
        $sql = "UPDATE user Set Password =? WHERE login=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
            header("location: ../signup.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss",$hashedPwd,$login);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../manageaccount.php?error=none");
        exit();
    }
}
function remindPassword($conn,$login)
{
    $sql = "SELECT email FROM user WHERE login =? or email=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$login,$login);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultData);
    $email=$row['email'];
    $msg = "First line of text\nSecond line of text";
    $msg = wordwrap($msg,70);
    mail($email,"My subject",$msg);
    header("location: ../login.php?remind=".$email);
    exit();
}
function emptyInputSuggestion($suggestion)
{
    $result;
    if(empty($suggestion))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function toLongSuggestion($suggestion)
{
    $result;
        if(strlen($suggestion)>500)
        {
            $result = true;
        }
        else $result = false;
        return $result;
}
function addSuggestion($conn,$suggestion,$iduser)
{
    $status = "1";
    $sql = "INSERT INTO suggestions (suggestion,id_user,id_status) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../suggestion.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss",$suggestion,$iduser,$status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../suggestion.php?error=none");
    exit();
}
function hasdog($conn,$id)
{

    $sql = "SELECT * FROM dog WHERE id_user = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $row=mysqli_num_rows($resultData);
    if($row==0)
    {
        echo '<a href="../inzynierka/adddog.php">Dodaj Psa</a>';
    }
    else if($row==1)
    {
        echo '<a href="../inzynierka/editdog.php">Edytuj Psa</a>';
    }
    mysqli_stmt_close($stmt);
}
function adddog($conn,$name,$size,$opis,$user)
{

    $sql = "INSERT INTO dog (id_user,name,size,opis) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../adddog.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss",$user,$name,$size,$opis);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

}
function editdog($conn,$name,$size,$opis,$user)
{
    $sql="UPDATE dog SET 
                name=IFNULL(?,name),
                size=IFNULL(?,size),
                opis=IFNULL(?,opis)
                WHERE id_user =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../editdog.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss",$name,$size,$opis,$user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../editdog.php?error=none");
    exit();
}
function addwalk($conn, $spot, $date,$description,$addinguser)
{
    $sql = "INSERT INTO walk (id_spot,id_user,time,description) VALUES ((Select id from spot WHERE name =?),?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../addwalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss",$spot,$addinguser,$date,$description);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../addwalk.php?error=none");
    exit();
}
function acceptWalk($conn,$iduser,$idwalk)
{
    $sql="UPDATE walk SET id_accompanied_user =? WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../findwalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$iduser,$idwalk);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managewalk.php?error=none");
    exit();
}
function approveWalk($conn,$idwalk)
{
    $approve = 1;
    $sql="UPDATE walk SET approved =? WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../managewalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$approve,$idwalk);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managewalk.php?error=none");
    exit();
}
function denyWalk($conn,$idwalk)
{
    $deny = 1;
    $sql="UPDATE walk SET cancelled =? WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../managewalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$deny,$idwalk);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

}
function cancellMessage($conn,$idwalk,$idcancellinguser)
{
    $message="Spacer został anulowany";
    $sql = "INSERT INTO chat (id_walk,id_sending_user,Message) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../managewalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sis",$idwalk,$idcancellinguser,$message);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managewalk.php?error=none");
    exit();
}
function sendMessage($conn,$idwalk,$idsendinguser,$message)
{
    $sql = "INSERT INTO chat (id_walk,id_sending_user,Message) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../chat.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sis",$idwalk,$idsendinguser,$message);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../chat.php?id=".$idwalk);
    exit();
}
function deleteMessage($conn,$idwalk,$idmessage)
{
    $delete = "Wiadomość została usunięta";
    $sql="UPDATE chat SET Message =? WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../chat.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$delete,$idmessage);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../chat.php?id=".$idwalk);
    exit();
}
function setDisplayedMessage($conn,$idmessage)
{
    $displayed = 1;
    $sql="UPDATE chat SET displayed =? WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../chat.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$displayed,$idmessage);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}
function editWalk($conn,$idwalk,$spot,$date,$description)
{
    $sql="UPDATE walk SET 
                id_spot=IFNULL((Select id from spot WHERE name =?),id_spot),
                time=IFNULL(?,time),
                description=IFNULL(?,description),
                last_edited=NOW()
                WHERE id=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../managewalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss",$spot,$date,$description,$idwalk);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managewalk.php?error=none");
    exit();
}
function reportUser($conn,$reason,$user,$reporteduser)
{
    $sql = "INSERT INTO notification (id_user,id_reported_user,reason) VALUES (?,(SELECT id FROM user WHERE login =?),?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ../managewalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss",$user,$reporteduser,$reason);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../managewalk.php?error=none");
    exit();
}
function emptyField($field)
{
    if(empty($field))
    {
        $result = true;
    }
    else
    {
        $result = false;
    }
    return $result;
}
function hasunreadMessage($conn,$id)
{
    $sqli = 'SELECT id FROM walk WHERE id_user="'.$id.'" OR id_accompanied_user="'.$id.'"';
    $result = mysqli_query($conn, $sqli);
    $row = mysqli_fetch_array($result);
    $sql2='Select count(displayed) FROM chat WHERE displayed="0" AND id_walk="'.$row['id'].'" AND id_sending_user!="'.$id.'"';
    $result2 = mysqli_query($conn, $sql2);
    $row2=mysqli_fetch_array($result2);
    echo 'Masz: '.$row2['count(displayed)'].' nowych wiadmości';
}