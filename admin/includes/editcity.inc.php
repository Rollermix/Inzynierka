<?php
session_start();
require_once 'dbh.inc.php';
require_once 'adminfunctions.inc.php';
require_once '../../includes/functions.inc.php';
if(isset($_POST["submit"])) {
    $voivodship = $_POST["voivodship"];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $id = $_SESSION['idcity'];
    editcity($conn,$id, $voivodship, $name, $description);
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
                $sql="UPDATE city SET image_path = ? WHERE city.id = '".$id."'";
                $stmt = mysqli_stmt_init($conn);
                var_dump( $stmt);
                mysqli_stmt_prepare($stmt,$sql);
                mysqli_stmt_bind_param($stmt, "ss",$fileName,$_SESSION['userid']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("location: ../managecities.php?error=updated");
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
else {
    header("location: ../managecities.php");

    exit();
}
