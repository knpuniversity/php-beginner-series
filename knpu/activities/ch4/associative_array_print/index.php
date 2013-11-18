<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Arrays!</title>
    </head>
    <body>
        <?php
            $pancake = array(
                'Pancake',
                '1 year'
            );
        ?>

        <div class="pet">
            <div class="pet-name"><?php echo $pancake[0]; ?></div>
            <div class="pet-age"><?php echo $pancake[1]; ?></div>
            <div class="pet-breed"></div>
        </div>
    </body>
</html>