<?php

namespace Challenges\RequireInclude;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class IsolateFunctionUseRequireCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The pet toy business is really taking off! The site is getting
bigger and we need to stay organized! Move the `get_great_pet_toys()` function
out of `index.php` and into the new `lib/functions.php` file so we can
re-use it later.
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
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
        $fileBuilder->setEntryPointFilename('index.php');

        $fileBuilder->addFileContents('lib/functions.php', <<<EOF
<!-- put the get_great_pet_toys() function here -->
EOF
        );

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
        $phpGrader->assertInputContains('lib/functions.php', 'get_great_pet_toys(');
        $phpGrader->assertInputContains('index.php', 'require');
        $htmlGrader->assertElementContains('h3', 'Bacon Bone');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
require 'lib/functions.php';

\$toys = get_great_pet_toys();
?>

<?php foreach (\$toys as \$toy) { ?>
    <h3><?php echo \$toy['name']; ?></h3>
    <h4><?php echo \$toy['color']; ?></h4>
<?php } ?>
EOF
        );

        $correctAnswer->setFileContents('lib/functions.php', <<<EOF
<?php
function get_great_pet_toys()
{
    \$contents = file_get_contents(__DIR__.'/../toys.json');
    \$toys = json_decode(\$contents, true);

    return \$toys;
}

EOF
        );
    }
}
