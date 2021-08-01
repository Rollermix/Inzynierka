<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container">
<h1>DOGGO WALKS</h1>
<?= isset($_SESSION["useruid"]) ? "<p>Witaj ".$_SESSION["useruid"]."</p>" : "" ?>
<div>
<h2>Dostępne miasta</h2>
<table class="table table-hover">
    <thead>
        <tr class="bg-dark">
            <th scope="col">Województwo</th>
            <th scope="col">Miasto</th>
            <th scope="col">Opis</th>
        </tr>
    </thead>
    <tbody>
    <?php
    // TODO przenieść to do funkcji jakiejś, starajmy się unikać takich wywołań w widoku
        $sqli = "SELECT voivodship.name AS 'województwo', city.name, city.description,city.deleted From voivodship Inner Join city ON city.id_voivodship=voivodship.id";
        $result = mysqli_query($conn, $sqli);
        while ($row = mysqli_fetch_array($result)) {
            if($row['deleted']==0) {
            echo '<tr class="table-secondary">'.'<td>'.$row['województwo'].'</td>'.'<td>'.'<a href ="'.baseUrl() . '/views/contents/main.php?city='.$row['name'].'">'.$row['name'].'</a>'.'</td>'.'<td>'.$row['description'].'</td>'.'</tr>';
            }
        }
    ?>
    </tbody>
</table>
</div>
<?php
    // TODO: kod poniżej zostanie zwinięty do pliku .js
    if(isset($_GET['city'])) {
        $city = ($_GET['city']);
        $sqli = "SELECT spot.name,spot.description From spot Inner Join city ON spot.id_city=city.id WHERE city.name='" . $city."'";
        $result = mysqli_query($conn, $sqli);
        echo '<h3>Szczegóły miasta</h3>';
        if(mysqli_num_rows($result)) {
            echo '<table class="table table-hover">';
                echo '<thead>';
                    echo '<tr class="bg-dark">';
                        echo '<th scope="col">Nazwa</th>';
                        echo '<th scope="col">Opis</th>';
                    echo '</tr>';
                echo '</thead>';
                echo '<tbody>';
            while ($row = mysqli_fetch_array($result)) {
                echo '<tr class="table-secondary">';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['description'] . '</td>';
                echo '</tr>';
            }
                echo "</tbody>";
            echo '</table>';
        } else {
            echo "<p>Brak miejsc w danym mieście</p>";
        }
    }
?>

</div>
<?php require_once '../containers/footer.php'; ?>
