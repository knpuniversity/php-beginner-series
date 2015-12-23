<?php

namespace Challenges\ReadingFormData;

use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class FetchPOSTDataCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Our toy form is setup! Now, when the user submits the form, we need to capture
the information. Set the submitted name to a `\$name` variable, the description
to a `\$description` variable, then `var_dump()` both variables to see what's being
submitted.

Behind the scenes, we'll fill out the fields with a new toy idea we have and submit
so you can see what the data looks like.

EOF;
    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('new_toy.php', <<<EOF
<!-- set variables and var_dump() up here -->

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
        $request = $context->fakeHttpRequest('/new_toy.php', 'POST');
        $request->setPOSTData(array(
            'name' => 'Fluffy Pig Stuffed Animal',
            'description' => 'Your dog will *love* to chew and destroy this adorable pig!'
        ));
    }

    public function grade(CodingExecutionResult $result)
    {
        $phpGrader = new PhpGradingTool($result);

        $phpGrader->assertInputContains('new_toy.php', '$_POST');
        $phpGrader->assertVariableEquals('name', 'Fluffy Pig Stuffed Animal');
        $phpGrader->assertVariableEquals('description', 'Your dog will *love* to chew and destroy this adorable pig!');
        $phpGrader->assertInputContains('new_toy.php', 'var_dump');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('new_toy.php', <<<EOF
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
    }
}
