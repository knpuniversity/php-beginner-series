<?php

namespace Challenges\IfStatement;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class FixErrorsIfElseCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Oh no, management tried coding again, someone put a pin code
on the github repo! Fix the errors below.
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
        if (array_key_exists('color', \$toy) && \$toy['color'] = 'surprise') {
            echo 'Surprise Color!';
        } elseif !array_key_exists('color', \$toy) {
            echo 'no color';
        } else {
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
        "color": "surprise"
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
        $result->assertElementContains('h4', 'Surprise Color');
        $result->assertElementContains(
            'h4',
            'Yellow',
            'The Tennis ball is printing as `Surprise Color!`, but it *should* be `Yellow`. There\'s a more subtle mistake in the first part of the `if` statement...'
        );
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
        if (array_key_exists('color', \$toy) && \$toy['color'] == 'surprise') {
            echo 'Surprise Color!';
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
