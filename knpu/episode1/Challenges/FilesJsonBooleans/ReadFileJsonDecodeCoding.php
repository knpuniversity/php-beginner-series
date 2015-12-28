<?php

namespace Challenges\FilesJsonBooleans;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class ReadFileJsonDecodeCoding implements CodingChallengeInterface
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

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<!-- read from the toys.json file and set the \$toys variable -->

<?php foreach (\$toys as \$toy) { ?>
    <h3><?php echo \$toy['name']; ?></h3>
    <h4><?php echo \$toy['color']; ?></h4>
<?php } ?>
EOF
        );
        $fileBuilder->setEntryPointFilename('index.php');

        $fileBuilder->addFileContents('toys.json', <<<EOF
[
    {
        "name": "Bacon Bone",
        "color": "Bacon-colored"
    },
    {
        "name": "Tennis Ball",
        "color": "Yellow"
    },
    {
        "name": "Frisbee",
        "color": "Red"
    }
]
EOF
        );

        return $fileBuilder;
    }

    public function getWorkerConfig(WorkerLoaderInterface $loader)
    {
        return $loader->load(__DIR__.'/../php_worker.yml');
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $phpGrader = new PhpGradingTool($result);
        $htmlGrader = new HtmlOutputGradingTool($result);

        $phpGrader->assertInputContains('index.php', 'file_get_contents');
        $phpGrader->assertInputContains('index.php', 'json_decode');
        $htmlGrader->assertElementContains('h3', 'Bacon Bone');
        $htmlGrader->assertElementContains('h4', 'Bacon-colored');
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
    <h4><?php echo \$toy['color']; ?></h4>
<?php } ?>
EOF
        );
    }
}
