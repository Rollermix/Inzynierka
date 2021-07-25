<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<?php
$idwalk = $_GET["id"];
$sqli = 'SELECT chat.*,user.login From chat INNER JOIN user ON chat.id_sending_user=user.id WHERE id_walk="'.$idwalk.'"';
$result = mysqli_query($conn, $sqli);
while ($row = mysqli_fetch_array($result)) {
    {
        echo 'Wysłał: '.$row['login'].' Kiedy: '.$row['Date'];
        if($row['login']==$_SESSION['useruid']) {
            echo '<button>' . '<a href="includes/deletemessage.inc.php?idmessage=' . $row['id'] . '&idwalk=' . $idwalk . '">' . 'Usuń wiadomość' . '</a></button>';
            echo '<br>' . $row['Message'] . '<br>';
        }
        else if($row['login']!=$_SESSION['useruid'])
    {
        setDisplayedMessage($conn,$row['id']);
        echo '<br>' . $row['Message'] . '<br>';
    }

    }
}
echo '<form action="includes/chat.inc.php?id='.$idwalk.'" method="post">';
?>
    <input type = "text" name="message" placeholder="Wpisz wiadomość">
    <button type = "submit" name ="submit">Wyślij</button>
</form>
<?php require_once '../containers/footer.php'; ?>
