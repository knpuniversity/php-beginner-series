<?php

namespace Challenges\FilesJsonBooleans;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class ReadFileJsonDecode implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The toy inventory lives in a `toys.json` file. Great! Let's
read this file, and use `json_decode` to turn it into a big array.
Make sure the `foreach` is still correctly printing each toy's details.
And be careful to make sure the keys from `toys.json` match what you're
printing out!
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<!-- read from the toys.json file and set the \$toys variable -->

<?php foreach (\$toys as \$toy) { ?>
    <h3><?php echo \$toy['name']; ?></h3>
    <h4><?php echo \$toy['color']; ?></h4>
<?php } ?>
EOF
        );
        $fileBuilder->addFileContents('toys.json', <<<EOF
[
    {
        "name": "Bacon Bone",
        "toy_color": "Bacon-colored"
    },
    {
        "name": "Tennis Ball",
        "toy_color": "Yellow"
    },
    {
        "name": "Frisbee",
        "toy_color": "Red"
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
        $result->assertInputContains('index.php', 'file_get_contents');
        $result->assertInputContains('index.php', 'json_decode');
        $result->assertElementContains('h3', 'Bacon Bone');
        $result->assertElementContains('h4', 'Bacon-colored');
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
    <h4><?php echo \$toy['toy_color']; ?></h4>
<?php } ?>
EOF
        );
    }
}
