<?php

namespace Challenges\ArraysLoops;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class ForEachCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The kids are ready to work! Let's advertise the new service.
Use a `foreach` loop to print each kid's name in an `h3` tag.
Include a `<button>Schedule me</button>` under each kid's name:
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
        $result->assertInputContains('index.php', 'foreach');
        $result->assertElementContains('h3', 'Kitty');
        $result->assertElementContains('h3', 'Tiger');
        $result->assertElementContains('h3', 'Jay');

        $buttonCount = substr_count($result->getOutput(), '<button>');
        if ($buttonCount == 0) {
            throw new GradingException('Don\'t forget to add a `<button>Schedule me</button>` inside the `foreach` for each walker!');
        }
        if ($buttonCount == 1) {
            throw new GradingException(
                'I only see 1 `<button>` - make sure to include this *inside* the `foreach` loop so that 3 are printed'
            );
        }
        if ($buttonCount != 3) {
            throw new GradingException('There should be 3 `<button>` element exactly');
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
\$walker1 = 'Kitty';
\$walker2 = 'Tiger';
\$walker3 = 'Jay';

\$dogWalkers = array(\$walker1, \$walker2, \$walker3);
foreach (\$dogWalkers as \$dogWalker) {
    echo '<h3>';
    echo \$dogWalker;
    echo '<button>Schedule me</button>';
    echo '</h3>';
}
?>
EOF
        );
    }
}
