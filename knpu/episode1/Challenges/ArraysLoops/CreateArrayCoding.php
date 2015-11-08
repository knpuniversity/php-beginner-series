<?php

namespace Challenges\ArraysLoops;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class CreateArrayCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
We're testing out a new feature: find someone to walk your
dog! At first, our boss's kids will be the three dog walkers:
`Kitty`, `Tiger`, and `Jay`. Assign each dog walker to three
new variables - `\$walker1`, `\$walker2` and `\$walker3`. Then,
put them into a `\$dogWalkers` array.
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
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

        $phpGrader->assertVariableEquals('dogWalkers', array(
            'Kitty',
            'Tiger',
            'Jay',
        ));
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
\$walker1 = 'Kitty';
\$walker2 = 'Tiger';
\$walker3 = 'Jay';

\$dogWalkers = array(\$walker1, \$walker2, \$walker3);
?>
EOF
        );
    }
}
