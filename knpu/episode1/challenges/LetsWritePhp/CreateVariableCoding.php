<?php

namespace Challenges\LetsWritePhp;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class CreateVariableCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The management of AirPupNMeow is always changing its mind. To simplify
the life of our devs, let's use a variable so that when management
changes the tag line, we only have to update one spot. Create
a variable called `airpupTag` and set it to `I luv kittens`. Then print
this inside the `<h2>` tag.
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();

        $fileBuilder->addFileContents('index.php', <<<EOF
<!-- create the variable here -->

<h2>
    <!-- print the variable here -->
</h2>
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

        $expected = 'I luv kittens';
        $phpGrader->assertVariableEquals('airpupTag', $expected);
        $phpGrader->assertInputContains('index.php', 'echo');
        $htmlGrader->assertOutputContains($expected);
        $htmlGrader->assertElementContains('h2', $expected);
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<!-- create the variable here -->
<?php \$airpupTag = 'I luv kittens'; ?>

<h2>
    <?php echo \$airpupTag; ?>
</h2>
EOF
        );
    }
}
