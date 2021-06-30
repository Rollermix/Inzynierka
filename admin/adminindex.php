<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Praca inżynierska-logowanie</title>
</head>
<body>
<?php
require_once 'adminheader.php';
require_once 'includes/dbh.inc.php';
?>
<a>DOGGO WALKS</a>

<?php
if (isset($_SESSION["useruid"]))
{
    echo  "<p>Witaj ".$_SESSION["useruid"]."</p>";

}

?>

</body>
</html>
