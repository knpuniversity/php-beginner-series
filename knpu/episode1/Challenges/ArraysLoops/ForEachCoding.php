<?php

namespace Challenges\ArraysLoops;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

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

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
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

        $phpGrader->assertInputContains('index.php', 'foreach');
        $htmlGrader->assertElementContains('h3', 'Kitty');
        $htmlGrader->assertElementContains('h3', 'Tiger');
        $htmlGrader->assertElementContains('h3', 'Jay');

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
