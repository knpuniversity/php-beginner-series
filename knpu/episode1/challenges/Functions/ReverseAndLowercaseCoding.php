<?php

namespace Challenges\Functions;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

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

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<?php echo '!emosewaP yltcefrruP erA steP ruO'; ?>
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

        $expected = 'our pets are purrfectly pawesome!';
        $phpGrader->assertInputContains('index.php', 'strrev(');
        $phpGrader->assertInputContains('index.php', 'strtolower(');
        $htmlGrader->assertOutputContains($expected);
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php echo strtolower(strrev('!emosewaP yltcefrruP erA steP ruO')); ?>
EOF
        );
    }
}
