<!DOCTYPE html>
<html lang="en-us">
    <head>
        <title>Chapter 3 already? You're killing it!</title>
    </head>
    <body>
        <?php
            $things = array('ice cream', 'high-fives', 'vacation');
        ?>
        <ul>
            <?php
                foreach ($things as $thing) {
                    echo '<li class="my-favorite">';
                    echo $thing;
                    echo '</li>';
                }
            ?>
        </ul>

        <div class="second-thing"></div>
    </body>
</html>