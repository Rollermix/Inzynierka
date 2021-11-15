<?php
session_start();
require_once 'dbh.inc.php';
require_once 'functions.inc.php';
if(isset($_POST["submit"])) {

    $option = "Wybierz rozmiar psa...";
    $name = $_POST["name"];
    $size = $_POST["size"];
    if ($size==$option)
    {
        $size=NULL;
    }
    $opis = $_POST["opis"];

    if (!$name || !$size || !$opis) {
        header("location: " . baseUrl() . "/views/contents/adddog.php?error=emptyinput");
        exit();
    }
    $user = $_SESSION["userid"];
    adddog($conn, $name, $size, $opis, $user);

    $statusMsg = '';

// File upload path
    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (isset($_POST["submit"]) && !empty($_FILES["file"]["name"])) {
        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'JPG', 'PNG', 'JPEG');
        if (in_array($fileType, $allowTypes)) {
            // Upload file to server
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                // Insert image file name into database
                $sql = "UPDATE dog SET image_path =IFNULL(?,image_path) WHERE id=(SELECT id From dog where id_user=?)";
                $stmt = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("location: " . baseUrl() . "/views/contents/adddog.php?error=stmtfailed");
                    exit();
                }
                mysqli_stmt_bind_param($stmt, "ss", $fileName, $_SESSION['userid']);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
                header("location: " . baseUrl() . "/views/contents/profile.php?error=none");
                exit();
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    } else {
        $statusMsg = 'Please select a file to upload.';
    }

// Display status message
    echo $statusMsg;
}