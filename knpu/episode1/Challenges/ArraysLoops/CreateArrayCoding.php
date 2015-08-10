<?php

namespace Challenges\ArraysLoops;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

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

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
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
        $result->assertVariableEquals('dogWalkers', array(
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
