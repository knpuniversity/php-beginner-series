<?php

namespace Challenges\Functions;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

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

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
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

    public function getExecutionMode()
    {
        return self::EXECUTION_MODE_PHP_NORMAL;
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $expected = 'I luv puppies';
        $result->assertInputContains('index.php', 'rand(');
        $result->assertOutputContains($expected);

        $text = trim($result->getCrawler()->filter('h3 span')
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
