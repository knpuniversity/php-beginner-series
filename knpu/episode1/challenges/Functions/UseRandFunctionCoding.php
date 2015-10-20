<?php

namespace Challenges\Functions;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class UseRandFunctionCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
It's hard to keep track of how many loveable pets we have
at a time. To save time (read: make management happy) just print
a random number - between 100 and 200 - for the number of tail-wagging
pets we have available.
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<?php
\$airpupTag = 'I luv puppies';
?>

<h2><?php echo \$airpupTag; ?></h2>

<h3>
    <span>
        <!-- print a random number here -->
    </span>

    pets waiting to meet you
</h3>
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

        $expected = 'I luv puppies';
        $phpGrader->assertInputContains('index.php', 'rand(');
        $htmlGrader->assertOutputContains($expected);

        $text = trim($htmlGrader->getCrawler()->filter('h3 span')
            ->text());

        if (!is_numeric($text)) {
            throw new GradingException(sprintf(
                'Are you printing the random number inside the span tag? I see "%s"',
                $text
            ));
        }
        if ($text > 200 || $text < 100) {
            throw new GradingException(sprintf(
                'Make sure the rand() function only returns numbers between 100 and 200',
                $text
            ));
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
\$airpupTag = 'I luv puppies';
?>

<h2><?php echo \$airpupTag; ?></h2>

<h3>
    <span>
        <?php echo rand(100, 200); ?>
    </span>

    pets waiting to meet you
</h3>
EOF
        );
    }
}
