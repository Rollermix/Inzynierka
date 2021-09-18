<?php
session_start();
require_once '../../includes/functions.inc.php';

if(isset($_POST["submit"]))
{
    $check='Wybierz województwo...';
    $voivodshipid = $_POST["voivodship"];
    $name = $_POST['name'];
    $description = $_POST['description'];
    require_once 'dbh.inc.php';
    require_once 'adminfunctions.inc.php';
    if ($voivodshipid === $check)
    {
        header("location: ../managecities.php?error=errorinputvoivodship");
        exit();
    }
    if(emptyInputAdd($name)!==false)
    {
        header("location: ../managecities.php?error=emptyinputcity");
        exit();
    }
    addcity($conn,$voivodshipid,$name,$description);
    $statusMsg = '';

// File upload path
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

    if(isset($_POST["submit"]) && !empty($_FILES["file"]["name"])){
        // Allow certain file formats
        $allowTypes = array('jpg','png','jpeg','JPG','PNG','JPEG');
        if(in_array($fileType, $allowTypes)){
            // Upload file to server
            if(move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)){
                // Insert image file name into database
                $sql="UPDATE city SET image_path =IFNULL(?,image_path) WHERE city.name = '".$_POST['name']."'";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql))
                {
                    header("location: ". baseUrl() ."/admin/managecities.php?error=stmtfailed");
                    exit();
                }
                mysqli_stmt_bind_param($stmt, "ss",$fileName,$_SESSION['userid']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("location: ". baseUrl() ."/admin/managecities.php?error=none");
                exit();
            }else{
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        }else{
            $statusMsg = 'Sorry, only JPG, JPEG, PNG files are allowed to upload.';
        }
    }else{
        $statusMsg = 'Please select a file to upload.';
    }

// Display status message
    echo $statusMsg;
}
else
{
    header("location: ../managecities.php");
    exit();
}