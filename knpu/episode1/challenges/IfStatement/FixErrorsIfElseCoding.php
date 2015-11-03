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
        $htmlGrader->assertElementContains('h4', 'Surprise Color');
        $htmlGrader->assertElementContains(
            'h4',
            'Yellow',
            'The Tennis ball is printing as `Surprise Color!`, but it *should* be `Yellow`. There\'s a more subtle mistake in the first part of the `if` statement...'
        );
        $htmlGrader->assertElementContains('h4', 'no color');
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
