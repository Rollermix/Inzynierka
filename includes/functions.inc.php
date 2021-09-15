<?php

if(file_exists(stream_resolve_include_path('../../config.php'))) {
    require_once('../../config.php');
}
if(file_exists(stream_resolve_include_path('../config.php'))) {
    require_once('../config.php');
}

require_once('models.php');

function baseUrl() {
    global $CONFIG;

    if(!isset($CONFIG->base_url)) {
        return 'http://localhost';
    }

    return $CONFIG->base_url;
}

function emptyInputSignup($firstname,$lastname,$login,$email,$password,$repeatpassword)
{
    return empty($firstname) || empty($lastname) || empty($login) || empty($email) || empty($password) || empty($repeatpassword);
}
function invalidLogin($login)
{
    return !preg_match("/^[a-zA-Z0-9]+$/",$login);
}
function invalidEmail($email)
{
    return !filter_var($email, FILTER_VALIDATE_EMAIL);
}
function pwdMatch($password, $repeatpassword)
{
    return $password !== $repeatpassword;
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
    if($row = mysqli_fetch_assoc($resultData))
    {
        mysqli_stmt_close($stmt);
        return $row;
    }
    else
    {
        mysqli_stmt_close($stmt);
        return false;
    }
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
    return empty($login) || empty($password);
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
    else {
        session_start();
        $_SESSION["userid"] = $uidExists["id"];
        $_SESSION["useruid"] = $uidExists["login"];
        $_SESSION['loggedin'] = true;
        header("location: ../index.php");
        exit();
    }
}
function isLogged() {
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'];
}

function redirectToPage($page) {
    header("location: ". $page);
    exit();
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

    mysqli_stmt_close($stmt);
    return $row['deleted'] == 1;
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
    return empty($password) || empty($newpassword) || empty($repeatnewpassword);
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
    header("location: ". baseUrl() ."/views/contents/login.php?error=remindnone");
    exit();
}
function emptyInputSuggestion($suggestion)
{
    return empty($suggestion);
}
function toLongSuggestion($suggestion)
{
    return strlen($suggestion)>500;
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

    return $row > 0;
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
function readReminder($conn,$id)
{
    $sqli ='Update reminder SET displayed = 1 WHERE id=?';
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sqli))
    {
        header("location: ". baseUrl() ."/views/contents/reminder.php?error=stmtfailed");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "s",$id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getDogDetailsByUserId($conn, $userid) {
    $sqli ='SELECT * FROM dog WHERE dog.id_user = "'.$userid.'"';
    $messages = mysqli_query($conn, $sqli);
    $results = mysqli_fetch_array($messages);
    return $results;
}

function setSelectValue($valueToCheck, $optionValue) {
    return !strcmp($valueToCheck, $optionValue) ? 'selected="selected"' : '';
}

function isAdmin($conn,$login)
{
    $email = $login;
    $uidExists = loginExists($conn, $login, $email);
    if($uidExists === false)
    {
        header("location: ". baseUrl() ."/views/contents/login.php?error=wrongLogin");
        exit();
    }

    if (boolval($uidExists["admin"])) // ;_; sorry
    {
        return true;
    }

    return false;
}

function getCitiesData($conn, $get_deleted = true) {

    $cities = [];

    $sqli = "SELECT voivodship.name AS 'voivodeship', city.* 
             FROM voivodship 
             INNER JOIN city 
                 ON city.id_voivodship=voivodship.id";
    $result = mysqli_query($conn, $sqli);
    while ($row = mysqli_fetch_object($result)) {
        $city = new CityDto($row);
        $cities[] = $city;
    }

    foreach ($cities as &$city) {
        $sqli = "SELECT spot.name, spot.description, spot.id_city 
                 FROM spot 
                 INNER JOIN city 
                     ON spot.id_city=city.id 
                 WHERE city.id='" . $city->id."'";
        $result = mysqli_query($conn, $sqli);
        while ($spot = mysqli_fetch_object($result)) {
            if($spot->id_city === $city->id) {
                $city->addSpot($spot);
            }
        }

    }

    return $cities;
}

function getDogsAndItsOwners($conn) {

    $dogsWithOwners = [];
    $sqli = "Select user.id,     CONCAT(user.name, ' ', user.surname) as fullname ,user.email,dog.image_path as dogimage,
       dog.size, dog.name AS dogname, dog.opis FROM user INNER JOIN dog ON user.id=dog.id_user";
    $result = mysqli_query($conn, $sqli);
    while ($row = mysqli_fetch_array($result)) {
        $dogsWithOwners[] = $row;
    }

    return $dogsWithOwners;
}

function getUsernameById($conn, $id) {
    $sqli = "Select CONCAT(user.name, ' ', user.surname) as fullname
             FROM user WHERE user.id='".$id."'";
    $result = mysqli_query($conn, $sqli);
    return mysqli_fetch_array($result);
}

function redirectIfLoggedIn() {
    if(isLogged()) {
        redirectToPage(baseUrl() . '/views/contents/start.php');
        exit();
    }
}