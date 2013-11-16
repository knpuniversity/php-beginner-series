<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Arrays in your Arrays!</title>
    </head>
    <body>
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
        ?>

        <div class="pet">
            <div class="pet-name"><?php echo $pancake['name']; ?></div>
            <div class="pet-age"><?php echo $pancake['age']; ?></div>
            <div class="pet-breed"><?php echo $pancake['breed']; ?></div>
        </div>
        <!-- Ah! Duplication! No!!!! Halp! -->
        <div class="pet">
            <div class="pet-name"><?php echo $pet2['name']; ?></div>
            <div class="pet-age"><?php echo $pet2['age']; ?></div>
            <div class="pet-breed"><?php echo $pet2['breed']; ?></div>
        </div>
        <div class="pet">
            <div class="pet-name"><?php echo $pet3['name']; ?></div>
            <div class="pet-age"><?php echo $pet3['age']; ?></div>
            <div class="pet-breed"><?php echo $pet3['breed']; ?></div>
        </div>

    </body>
</html>