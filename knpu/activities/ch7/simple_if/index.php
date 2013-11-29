<?php
    $petsJson = file_get_contents('pets.json');
    $pets = json_decode($petsJson, true);
?>

<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>If Statements!</title>
    </head>
    <body>
        <?php foreach ($pets as $pet) { ?>
            <div class="pet">
                <div class="pet-name">
                    <?php echo $pet['name']; ?>
                </div>
                <div class="pet-age">
                    <?php echo $pet['age']; ?>
                </div>
                <div class="pet-breed">
                    <?php echo $pet['breed']; ?>
                </div>
                <div class="pet-weight">
                    <?php echo $pet['weight']; ?>
                </div>
            </div>
        <?php } ?>

    </body>
</html>