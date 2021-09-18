<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
if(isset($_POST["submit"])) {
    require_once 'dbh.inc.php';

    $name= $_POST["name"];
    $size = $_POST["size"];
    $opis = $_POST["opis"];
    if(!$name || !$size || !$opis) {
        header("location: ". baseUrl() ."/views/contents/editdog.php?error=emptyinput");
        exit();
    }
    $user = $_SESSION["userid"];
    if(empty($opis))
        $opis=NULL;
    if($size=="Wybierz rozmiar psa...")
        $size=NULL;
    if(empty($name))
        $name=NULL;
    editdog($conn,$name,$size,$opis,$user);
}
$statusMsg = '';

// File upload path
$targetDir = "uploads/";
$fileName = basename($_FILES["file"]["name"]);
$targetFilePath = $targetDir . $fileName;
$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

if(isset($_POST["submit"])){
    // Allow certain file formats
    $allowTypes = array('jpg','png','jpeg','JPG','PNG','JPEG');
    if(in_array($fileType, $allowTypes)){
        // Upload file to server
        if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
            // Insert image file name into database
            $sql="UPDATE dog SET image_path =IFNULL(?,image_path) WHERE id=(SELECT id From dog where id_user=?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql))
            {
                header("location: ". baseUrl() ."/views/contents/editdog.php?error=stmtfailed");
                exit();
            }
            mysqli_stmt_bind_param($stmt, "ss",$fileName,$_SESSION['userid']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("location: ". baseUrl() ."/views/contents/editdog.php?error=none");
            exit();
        }else{
            $statusMsg = "Wystąpił błąd podczas wysyłania zdjęcia psa - proszę zgłoś się do administratora.";
        }
    }else{
        $statusMsg = 'Niepoprawny typ grafiki - dozwolone są formaty: .jpg, .jpeg, .png';
    }
}else{
    $statusMsg = 'Wybierz grafikę.';
}

// Display status message
echo $statusMsg;
