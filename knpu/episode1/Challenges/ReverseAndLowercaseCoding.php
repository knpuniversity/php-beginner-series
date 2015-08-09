<?php

namespace Challenges;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class ReverseAndLowercaseCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Someone was working at midnight, and started printing out
things in reverse! Don't worry! We've sent them on holiday and
now it's your job to fix things. As a challenge, see if you
can reverse and set all characters to lowercase in one line
using functions.
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<?php echo '!emosewaP yltcefrruP erA steP ruO'; ?>
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
        $expected = 'our pets are purrfectly pawesome!';
        $result->assertInputContains('index.php', 'strrev(');
        $result->assertInputContains('index.php', 'strtolower(');
        $result->assertOutputContains($expected);
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php echo strtolower(strrev('!emosewaP yltcefrruP erA steP ruO')); ?>
EOF
        );
    }
}
