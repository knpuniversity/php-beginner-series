<?php
    $pancake = array(
        'name' => 'Pancake',
        'age'  => '1 year',
        'breed' => 'Bulldog',
    );
    $pet2 = array(
        'name' => 'Spark Pug',
        'age'  => '1 year',
        'breed' => 'Pug',
    );
    $pet3 = array(
        'name' => 'Pico de Gato',
        'age'  => '5 years',
        'breed' => 'Bengal',
    );

    $petsJson = file_get_contents('pets.json');

    $pets = array($pancake, $pet2, $pet3);
?>

<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>JSON and Files!</title>
    </head>
    <body>
        <?php foreach ($pets as $pet) { ?>
            <div class="pet">
                <div class="pet-name"><?php echo $pet['name']; ?></div>
                <div class="pet-age"><?php echo $pet['age']; ?></div>
                <div class="pet-breed"><?php echo $pet['breed']; ?></div>
            </div>
        <?php } ?>

    </body>
</html>