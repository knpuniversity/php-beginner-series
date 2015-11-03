<?php

namespace Challenges\IfStatement;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class IfNoToyColorCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Oh no! Some of the toys are missing a `color` key and now the page
is giving us a huge error!  Use an `if` statement to fix this.
If we don't know the color, print `no color`.
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
        "name": "Bacon Bone"
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

        $phpGrader->assertInputContains('index.php', 'if');
        $phpGrader->assertInputContains('index.php', 'array_key_exists');
        // make sure they're still printing
        $htmlGrader->assertOutputContains(
            'no color',
            'The `Bacon Bone` doesn\'t have a color, so it *should* say "no color" for that toy.'
        );
        $htmlGrader->assertElementContains('h4', 'Yellow');
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
        <?php if (array_key_exists('color', \$toy)) { ?>
	        <?php echo \$toy['color']; ?>
        <?php } else { ?>
            no color
        <?php } ?>
	</h4>
<?php } ?>
EOF
        );
    }
}
