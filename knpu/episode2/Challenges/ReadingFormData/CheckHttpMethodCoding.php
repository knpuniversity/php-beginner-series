<?php

namespace Challenges\ReadingFormData;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

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

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('new_toy.php', <<<EOF
<?php
\$name = \$_POST['name'];
\$description = \$_POST['description'];

var_dump(\$name, \$description);
?>

<form action="/new_toy.php" method="POST">
    <input type="text" name="toy_name" />
    <textarea name="description"></textarea>

    <button type="submit">Add toy</button>
</form>
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
        $request = $context->fakeHttpRequest('/new_toy.php', 'GET');
    }

    public function grade(CodingExecutionResult $result)
    {
        $result->assertInputContains('new_toy.php', '$_SERVER');
        $result->assertInputContains('new_toy.php', 'REQUEST_METHOD');
        $result->assertInputContains('new_toy.php', 'POST', 'Are you checking that the request method equals POST?');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('new_toy.php', <<<EOF
<?php
if (\$_SERVER['REQUEST_METHOD'] == 'POST') {
    \$name = \$_POST['name'];
    \$description = \$_POST['description'];

    var_dump(\$name, \$description);
}
?>

<form action="/new_toy.php" method="POST">
    <input type="text" name="toy_name" />
    <textarea name="description"></textarea>

    <button type="submit">Add toy</button>
</form>
EOF
        );
    }
}
