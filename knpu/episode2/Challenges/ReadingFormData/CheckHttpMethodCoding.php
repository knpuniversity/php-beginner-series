<?php

namespace Challenges\ReadingFormData;

use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class CheckHttpMethodCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Great! When you press the submit button, we're printing out whatever was entered
into the form. Pretty soon, we'll start saving and selling the newest and loudest
squeeky toy ever invented!

But now, we're just surfing to the page directly and getting an error!
Add an `if` statement around our logic so that it only runs when the user submits
the form (i.e. makes a POST request).
EOF;
    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('new_toy.php', <<<EOF
<?php
\$name = \$_POST['name'];
\$description = \$_POST['description'];

var_dump(\$name, \$description);
?>

<form action="/new_toy.php" method="POST">
    <input type="text" name="name" />
    <textarea name="description"></textarea>

    <button type="submit">Add toy</button>
</form>
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
        $context->fakeHttpRequest('/new_toy.php', 'GET');
    }

    public function grade(CodingExecutionResult $result)
    {
        $phpGrader = new PhpGradingTool($result);

        $phpGrader->assertInputContains('new_toy.php', '$_SERVER');
        $phpGrader->assertInputContains('new_toy.php', 'REQUEST_METHOD');
        $phpGrader->assertInputContains('new_toy.php', 'POST', 'Are you checking that the request method equals POST?');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('new_toy.php', <<<EOF
<?php
if (\$_SERVER['REQUEST_METHOD'] == 'POST') {
    \$name = \$_POST['name'];
    \$description = \$_POST['description'];

    var_dump(\$name, \$description);
}
?>

<form action="/new_toy.php" method="POST">
    <input type="text" name="name" />
    <textarea name="description"></textarea>

    <button type="submit">Add toy</button>
</form>
EOF
            )
        ;
    }
}
