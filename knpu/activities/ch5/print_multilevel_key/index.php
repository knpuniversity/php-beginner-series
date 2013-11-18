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
            $pets = array($pancake, $pet2, $pet3);
        ?>

        <div class="spark-pug-breed"></div>
    </body>
</html>