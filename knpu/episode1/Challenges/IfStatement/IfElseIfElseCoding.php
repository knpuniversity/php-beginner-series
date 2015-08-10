<?php

namespace Challenges\IfStatement;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class IfElseIfElseCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The toys are really getting complicated now, so be careful!
Use an `if - elseif - else` statement to handle these three possible
situations:

#. If the `color` key exists and is set to `multiple`, print "Multiple Colors".
#. If the `color` key does not exist, print "no color"
#. Otherwise, print the actual color value
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<?php
\$contents = file_get_contents('toys.json');
\$toys = json_decode(\$contents, true);
?>

<?php foreach (\$toys as \$toy) { ?>
    <h3><?php echo \$toy['name']; ?></h3>
    <h4>
        <?php
        if (array_key_exists('color', \$toy)) {
            echo \$toy['color'];
        }
        ?>
    </h4>
<?php } ?>
EOF
        );
        $fileBuilder->setEntryPointFilename('index.php');

        $fileBuilder->addFileContents('toys.json', <<<EOF
[
    {
        "name": "Bacon Bone"
    },
    {
        "name": "Tennis Ball",
        "color": "Yellow"
    },
    {
        "name": "Frisbee",
        "color": "multiple"
    }
]
EOF
        );

        return $fileBuilder;
    }

    public function getExecutionMode()
    {
        return self::EXECUTION_MODE_PHP_NORMAL;
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $result->assertInputContains('index.php', 'if');
        $result->assertElementContains('h4', 'Yellow');
        $result->assertElementContains('h4', 'Multiple Colors');
        $result->assertElementContains('h4', 'no color');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
\$contents = file_get_contents('toys.json');
\$toys = json_decode(\$contents, true);
?>

<?php foreach (\$toys as \$toy) { ?>
    <h3><?php echo \$toy['name']; ?></h3>
    <h4>
        <?php
        if (array_key_exists('color', \$toy) && \$toy['color'] == 'multiple) {
            echo 'Multiple Colors';
        } elseif (!array_key_exists('color', \$toy)) {
            echo 'no color';
        } else {
            echo \$toy['color'];
        }
        ?>
    </h4>
<?php } ?>
EOF
        );
    }
}
