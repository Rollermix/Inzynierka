<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container">
    <h2 class="h2">Dostępne miasta</h2>
    <table class="table table-hover">
        <thead>
        <tr class="bg-dark">
            <th style="width: 10%" scope="col">#</th>
            <th scope="col">Województwo</th>
            <th scope="col">Miasto</th>
            <th scope="col">Opis</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $cities = getCitiesData($conn);
        foreach ($cities as $city) {
            $image = $city->image_city ? $city->image_city : (baseUrl() . '/assets/img/no_photo.jpg');
            echo '<tr class="table-secondary" id="' . $city->id . '">';
            echo '<td style="width: 10%"><img style="border-radius: 50%" src="' . $image . '" height=50></td>';

            echo '<td><span>' . $city->voivodeship . '</span><br>';
            echo '<span><i>dodano ' . mb_substr($city->created_at, 0, 10) . '</i></span></td>';
            echo '<td><span>' . $city->name . '</span><br>';
            if (count($city->spots)) {
                echo '<span>Liczba spotów: ' . count($city->spots) . ' (kliknij, aby rozwinąć)</span>';
            }
            echo "</td>";
            echo '<td>' . $city->description . '</td>';
            echo '</tr>';
            if (count($city->spots)) {
                foreach ($city->spots as $spot) {
                    echo '<tr class="table-dark hidden-js" data-cityid="' . $city->id . '">';
                    echo '<td style="background-color: #32383e"></td>';
                    echo '<td style="background-color: #32383e">' . $spot->name . '</td>';
                    echo '<td style="background-color: #32383e">' . $spot->description . '</td>';
                    echo '<td style="background-color: #32383e"></td>';
                    echo '</tr>';
                }
            }
        }
        ?>
        </tbody>
    </table>

    <?php require_once '../containers/footer.php'; ?>
