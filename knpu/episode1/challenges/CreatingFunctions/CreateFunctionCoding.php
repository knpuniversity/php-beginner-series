<?php

namespace Challenges\CreatingFunctions;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class CreateFunctionCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Being able to read all the toys from `toys.json` is pretty useful, and soon, it
might be handy to re-use this in other places too. Create a new `get_great_pet_toys()`
function that reads `toys.json`, decodes the contents, and returns the toys.
Call this to get the toys array.
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
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
        $fileBuilder->setEntryPointFilename('index.php');

        $fileBuilder->addFileContents('toys.json', <<<EOF
[
    {
        "name": "Bacon Bone",
        "color": "Bacon Colored"
    },
    {
        "name": "Tennis Ball",
        "color": "Yellow"
    },
    {
        "name": "Frisbee",
        "color": "Multiple Colors"
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

        $phpGrader->assertFunctionExists('get_great_pet_toys');
        $phpGrader->assertInputContains('index.php', 'get_great_pet_toys(');
        $htmlGrader->assertElementContains('h4', 'Yellow');
        $htmlGrader->assertElementContains('h4', 'Multiple Colors');
        $htmlGrader->assertElementContains('h3', 'Bacon Bone');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
function get_great_pet_toys()
{
    \$contents = file_get_contents('toys.json');
    \$toys = json_decode(\$contents, true);

    return \$toys;
}

\$toys = get_great_pet_toys();
?>

<?php foreach (\$toys as \$toy) { ?>
    <h3><?php echo \$toy['name']; ?></h3>
    <h4><?php echo \$toy['color']; ?></h4>
<?php } ?>
EOF
        );
    }
}
