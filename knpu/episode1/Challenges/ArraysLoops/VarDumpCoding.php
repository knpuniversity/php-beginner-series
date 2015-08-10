<?php

namespace Challenges\ArraysLoops;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class VarDumpCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The boss is worried that one of his kids was left off the
list! Use the `var_dump` function to show him that all three
kids are in the array.
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<?php
\$walker1 = 'Kitty';
\$walker2 = 'Tiger';
\$walker3 = 'Jay';

\$dogWalkers = array(\$walker1, \$walker2, \$walker3);
?>
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
        $result->assertInputContains('index.php', 'var_dump(');
        $result->assertOutputContains('Kitty', 'Tiger', 'Jay');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
\$walker1 = 'Kitty';
\$walker2 = 'Tiger';
\$walker3 = 'Jay';

\$dogWalkers = array(\$walker1, \$walker2, \$walker3);
var_dump(\$dogWalkers);
?>
EOF
        );
    }
}
