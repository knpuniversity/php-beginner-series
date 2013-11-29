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
            <?php $name = $pet['name']; ?>
            <div class="pet">
                <?php
                    if (strlen($name) > 8) {
                        if ($name == 'Spark Pug') {
                            echo 'Hey Sparky!';
                        } else {
                            echo $name;
                        }
                    } else {
                        echo 'Short name';
                    }
                ?>
            </div>
        <?php } ?>

    </body>
</html>