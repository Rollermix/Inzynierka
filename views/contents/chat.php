<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container custom-container">
    <?php
    $idwalk = $_GET["id"];
    $sqli = 'SELECT chat.*,user.login From chat 
    INNER JOIN user ON chat.id_sending_user=user.id WHERE id_walk="' . $idwalk . '"';
    $result = mysqli_query($conn, $sqli);
    while ($row = mysqli_fetch_array($result)) {
        {
            echo ' Kiedy: ' . $row['Date'];
            if ($row['login'] == $_SESSION['useruid']) {
                echo '<br><span class="your-message">' . $row['Message'] . '<br>';
                echo '<a style="color: white" href="' . baseUrl() . '/includes/deletemessage.inc.php?idmessage='
                    . $row['id'] . '&idwalk=' . $idwalk . '">' . 'Usuń wiadomość' . '</a></span>';
            } else {
                setDisplayedMessage($conn, $row['id']);
                echo '<br><span class="person-message">' . $row['Message'] . '</span><br>';
            }

        }
    }
    echo '<form action="' . baseUrl() . '/includes/chat.inc.php?id=' . $idwalk . '" method="post">';
    ?>
    <br><br>
    <div class="d-flex flex-row justify-content-between" style="">
        <div>
            <label class="no-margin">
                <input class="form-control" type="text" name="message" placeholder="Wpisz wiadomość" style="width: 25vw">
            </label>
        </div>
        <button class="btn btn-dark" type="submit" name="submit">Wyślij</button>
    </div>

    </form>
</div>
<?php require_once '../containers/footer.php'; ?>
