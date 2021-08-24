<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container">
    <h2 class="h2">Dostępne miasta</h2>
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
            $cities = getNotDeletesCitiesData($conn);
            foreach ($cities as $city) {
                echo '<tr class="table-secondary">';
                echo '<td><span>' . $city['voivodeship'] . '</span><br>';
                echo '<span><i>dodano ' . mb_substr($city['created_at'], 0, 10) . '</i></span></td>';
                echo '<td><a href="'.baseUrl().'/views/contents/main.php?city=' . $city['name'] . '">'.$city['name'].'</td>';
                echo '<td>' . $city['description'] . '</td>';
                echo '</tr>';
            }
        ?>
        </tbody>
    </table>
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
<div>

<?php require_once '../containers/footer.php'; ?>
