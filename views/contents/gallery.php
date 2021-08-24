<?php require_once '../containers/header.php'; ?>
<?php require_once '../containers/menu.php'; ?>
<div class="container">
<?php
    $dogsWithOwners = getDogsAndItsOwners($conn);
    $cardGroupLimiter = 1;
    foreach ($dogsWithOwners as $dogWithOwner) {
        if(!isset($dogWithOwner['dogimage']) || !$dogWithOwner['dogimage']) {
            $photo = baseUrl() . '/assets/img/no_photo.jpg';
        } else {
            $photo = $CONFIG->dog_images_path .$dogWithOwner['dogimage'];
        }

        if($cardGroupLimiter == 1) {
            echo '<div class="card-group">';
        }
        $cardGroupLimiter += 1;

        echo '<div class="card" style="width: 344px; max-width: 344px">';
            echo '<img class="card-img-top" src="'.$photo.'" alt="">';
            echo '<div class="card-body">';
                echo '<p class="card-text">';
                    echo '<span>Imię psa:'.$dogWithOwner['dogname'].'</span><br>';
                    echo '<span>Opis psa:'.$dogWithOwner['opis'].'</span><br>';
                    echo '<span>Właściciel: '.$dogWithOwner['fullname'].'</span><br>';
                echo '</p>';
            echo '</div>';
        echo '</div>';
        if($cardGroupLimiter > 3) {
            echo '</div>';
            $cardGroupLimiter = 1;
        }
    }
?>
</div>
<?php require_once '../containers/footer.php'; ?>
