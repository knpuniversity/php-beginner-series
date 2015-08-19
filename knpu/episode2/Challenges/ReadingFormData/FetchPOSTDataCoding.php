<?php

namespace Challenges\ReadingFormData;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

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

EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('new_toy.php', <<<EOF
<!-- set variables and var_dump() up here -->

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
        // TODO - code up stuff to fake the form submit!
        // toy_name = "Fluffy Pig Stuffed Animal"
        // description = "Your dog will *love* to chew and destroy this adorable pig!"
    }

    public function grade(CodingExecutionResult $result)
    {
        $result->assertInputContains('new_toy.php', '$_POST');
        $result->assertVariableEquals('name', 'Fluffy Pig Stuffed Animal');
        $result->assertVariableEquals('description', 'Your dog will *love* to chew and destroy this adorable pig!');
        $result->assertInputContains('new_toy.php', 'var_dump');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('new_toy.php', <<<EOF
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
    }
}
