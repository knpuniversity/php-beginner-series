<?php

namespace Challenges\ReadingFormData;

use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class PlayingWithSERVERCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Dump the `\$_SERVER` variable and run your code to figure out which key stores information
about what browser you're using. It's ok that you'll have a wrong answer at first to
figure this out. *Hint* The browser information is a big long string that (in this
example) will include `Mozilla` in it.

Then, remove the dump, but print the browser information in the `h3` tag!
EOF;
    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('new_toy.php', <<<EOF
<h3>
Print the browser information of your user here
</h3>
EOF
            )
        ;

        return $builder;
    }

    public function getWorkerConfig(WorkerLoaderInterface $loader)
    {
        return $loader->load(__DIR__.'/../php_worker.yml');
    }

    public function setupContext(CodingContext $context)
    {
        $request = $context->fakeHttpRequest('/new_toy.php', 'GET');
        $request->addHeader('User-Agent', 'Mozilla/5.0 (iPad; U; CPU OS 3_2_1 like Mac OS X; en-us) AppleWebKit/531.21.10');
    }

    public function grade(CodingExecutionResult $result)
    {
        $htmlGrader = new HtmlOutputGradingTool($result);
        $phpGrader = new PhpGradingTool($result);

        $phpGrader->assertInputContains('new_toy.php', '$_SERVER');
        $phpGrader->assertInputContains('new_toy.php', 'HTTP_USER_AGENT');
        $htmlGrader->assertOutputContains('Mozilla/5.0 (iPad; U; CPU OS 3_2_1 like Mac OS X; en-us) AppleWebKit/531.21.10');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('new_toy.php', <<<EOF
<h3>
    <?php echo \$_SERVER['HTTP_USER_AGENT']; ?>
</h3>
EOF
            )
        ;
    }
}
