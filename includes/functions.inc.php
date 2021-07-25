<?php

if(file_exists(stream_resolve_include_path('../../config.php'))) {
    require_once('../../config.php');
}
if(file_exists(stream_resolve_include_path('../config.php'))) {
    require_once('../config.php');
}

function baseUrl() {
    global $CONFIG;

    if(!isset($CONFIG->base_url)) {
        return 'http://localhost';
    }

    return $CONFIG->base_url;
}

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
        header("location: ". baseUrl() ."/views/contents/signup.php?error=stmtfailed");
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
        header("location: ". baseUrl() ."/views/contents/signup.php?error=stmtfailed");
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
        header("location: ". baseUrl() ."/views/contents/signup.php?error=stmtfailed");
        exit();
    }
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "sssssss",$firstname,$lastname,$login,$email,$description,$hashedPwd,$city);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/signup.php?error=none");
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
        header("location: ". baseUrl() ."/views/contents/login.php?error=wrongLogin");
        exit();
    }
    $passwordHashed = $uidExists["password"];
    $checkPwd = password_verify($password, $passwordHashed);
    if($checkPwd === false)
    {
        header("location: ". baseUrl() ."/views/contents/login.php?error=wrongPassword");
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
        header("location: ". baseUrl() ."/views/contents/login.php?error=notLogged");
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
        header("location: ". baseUrl() ."/views/contents/signup.php?error=stmtfailed");
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
        header("location: ". baseUrl() ."/views/contents/signup.php?error=stmtfailed");
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
        header("location: ". baseUrl() ."/views/contents/manageaccount.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssssss",$firstname,$lastname,$email,$login,$description,$city,$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/manageaccount.php?error=none");
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
        header("location: ". baseUrl() ."/views/contents/manageaccount.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header ("location: ". baseUrl() ."/includes/logout.inc.php?deleted=true");
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
        header("location: ". baseUrl() ."/views/contents/login.php?error=wrongLogin");
        exit();
    }
    $passwordHashed = $uidExists["password"];
    $checkPwd = password_verify($password,$passwordHashed);
    if($checkPwd === false)
    {
        header("location: ". baseUrl() ."/views/contents/login.php?error=wrongPassword");
    }
    else
    {
        $hashedPwd = password_hash($newpassword, PASSWORD_DEFAULT);
        $sql = "UPDATE user Set Password =? WHERE login=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql))
        {
            header("location: ". baseUrl() ."/views/contents/signup.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ss",$hashedPwd,$login);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ". baseUrl() ."/views/contents/manageaccount.php?error=none");
        exit();
    }
}
function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function remindPassword($conn,$login)
{
    $password=randomPassword();
    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
    $sql = "SELECT email FROM user WHERE login =? or email=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$login,$login);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($resultData);
    $email=$row['email'];
    $msg = "Twoje nowe hasło to: ".$password." Zalecamy zmianę hasła po zalogowaniu";
    $msg = wordwrap($msg,70);
    mail($email,"My subject",$msg);
    $sql2 = "Update user SET password=? WHERE login =? or email=?;";
    $stmt2 = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt2,$sql2))
    {
        header("location: ". baseUrl() ."/views/contents/signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt2, "sss",$hashedPwd,$login,$login);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);
    header("location: ". baseUrl() ."/views/contents/login.php?error=none");
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
        header("location: ". baseUrl() ."/views/contents/suggestion.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss",$suggestion,$iduser,$status);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/suggestion.php?error=none");
    exit();
}
function hasDog($conn,$id)
{
    // TODO: wiem że pewnie to będziesz poprawiał, w sumie warto po prostu
    // być konsekwentnym pisząc metody bijące do bazy, bo się zastanawiałem
    // czemu to tu jest, a już w hasUnreadMessages już nie :D
    $sql = "SELECT * FROM dog WHERE id_user = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/signup.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    $row=mysqli_num_rows($resultData);

    mysqli_stmt_close($stmt);

    return $row > 0 ? true : false;
}
function adddog($conn,$name,$size,$opis,$user)
{

    $sql = "INSERT INTO dog (id_user,name,size,opis) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/adddog.php?error=stmtfailed");
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
        header("location: ". baseUrl() ."/views/contents/editdog.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss",$name,$size,$opis,$user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/editdog.php?error=none");
    exit();
}
function addwalk($conn, $spot, $date,$description,$addinguser)
{
    $sql = "INSERT INTO walk (id_spot,id_user,time,description) VALUES ((Select id from spot WHERE name =?),?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/addwalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss",$spot,$addinguser,$date,$description);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/addwalk.php?error=none");
    exit();
}
function acceptWalk($conn,$iduser,$idwalk)
{
    $sql="UPDATE walk SET id_accompanied_user =? WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/findwalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$iduser,$idwalk);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/managewalk.php?error=none");
    exit();
}
function approveWalk($conn,$idwalk)
{
    $approve = 1;
    $sql="UPDATE walk SET approved =? WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/managewalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$approve,$idwalk);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/managewalk.php?error=none");
    exit();
}
function denyWalk($conn,$idwalk)
{
    $deny = 1;
    $sql="UPDATE walk SET cancelled =? WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/managewalk.php?error=stmtfailed");
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
        header("location: ". baseUrl() ."/views/contents/managewalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sis",$idwalk,$idcancellinguser,$message);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/managewalk.php?error=none");
    exit();
}
function sendMessage($conn,$idwalk,$idsendinguser,$message)
{
    $sql = "INSERT INTO chat (id_walk,id_sending_user,Message) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/chat.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sis",$idwalk,$idsendinguser,$message);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/chat.php?id=".$idwalk);
    exit();
}
function deleteMessage($conn,$idwalk,$idmessage)
{
    $delete = "Wiadomość została usunięta";
    $sql="UPDATE chat SET Message =? WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/chat.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ss",$delete,$idmessage);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/chat.php?id=".$idwalk);
    exit();
}
function setDisplayedMessage($conn,$idmessage)
{
    $displayed = 1;
    $sql="UPDATE chat SET displayed =? WHERE id =?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/chat.php?error=stmtfailed");
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
        header("location: ". baseUrl() ."/views/contents/managewalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "ssss",$spot,$date,$description,$idwalk);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/managewalk.php?error=none");
    exit();
}
function reportUser($conn,$reason,$user,$reporteduser)
{
    $sql = "INSERT INTO notification (id_user,id_reported_user,reason) VALUES (?,(SELECT id FROM user WHERE login =?),?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("location: ". baseUrl() ."/views/contents/managewalk.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sss",$user,$reporteduser,$reason);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ". baseUrl() ."/views/contents/managewalk.php?error=none");
    exit();
}
function emptyField($field)
{
    return empty($field); // TODO: jak dla mnie redundant, zostawiam jako legacy code, do usuniecia
}
function hasUnreadMessages($conn, $id)
{
    $sqli = 'SELECT id FROM walk WHERE id_user="'.$id.'" OR id_accompanied_user="'.$id.'"';
    $isWalkAvailableForUser = mysqli_query($conn, $sqli);
    // jezeli nie ma spaceru, znaczy to tyle, ze nie ma gdzie wyslac wiadomosci;
    // TODO: lepiej to bedzie ogarnac w INNER JOIN czy tam LEFT JOIN, zamiast wysylac do mysql'a 
    // 2 razy zapytanie
    if(!$row = mysqli_fetch_array($isWalkAvailableForUser)) {
        return false;
    }
    $sqli = 'SELECT COUNT(displayed) as displayed_messages_count FROM chat WHERE displayed="0" AND id_walk="'. $row['id']. '" AND id_sending_user!="'.$id.'"';
    $messages = mysqli_query($conn, $sqli);
    $results = mysqli_fetch_array($messages);
    return $results['displayed_messages_count'];
}

