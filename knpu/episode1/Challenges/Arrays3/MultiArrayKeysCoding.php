<?php

namespace Challenges\Arrays3;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class MultiArrayKeysCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Let's get to know one of the friendliest pets in town!
Access the bio on Pancake and print it inside the `<h1>` tag.
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<?php
\$pets = array(
    array('name' => 'Pico de Gato', 'bio' => 'Spicy kitty'),
);
\$pets[] = array('name' => 'Waggy Pig', 'bio' => 'Little white dog');
\$pets[] = array('name' => 'Pancake', 'bio' => 'Breakfast is my favorite!');
?>

<h1>
    <!-- Print Pancake's bio here -->
</h1>
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

        $phpGrader->assertInputContains(
            'index.php',
            "\$pets[2]['bio']"
        );
        $htmlGrader->assertElementContains('h1', 'Breakfast is my favorite!');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
\$pets = array(
    array('name' => 'Pico de Gato', 'bio' => 'Spicy kitty'),
);
\$pets[] = array('name' => 'Waggy Pig', 'bio' => 'Little white dog');
\$pets[] = array('name' => 'Pancake', 'bio' => 'Breakfast is my favorite!');
?>

<h1>
    <?php echo \$pets[2]['bio']; ?>
</h1>
EOF
        );
    }
}
