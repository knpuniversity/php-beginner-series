<?php

namespace Challenges\SavingPets;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class FormSubmitLogicCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Let's finish the form submit logic! Fetch the existing pet toys with the `get_great_pet_toys()`
function, add the new toy to the array, then save the JSON back to `toys.json`. To
prove it's working, read the file again with `file_get_contents()` and `var_dump()`.

EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('new_toy.php', <<<EOF
<?php
require 'functions.php';

\$name = \$_POST['name'];
\$description = \$_POST['description'];

?>

<form action="/new_toy.php" method="POST">
    <input type="text" name="toy_name" />
    <textarea name="description"></textarea>

    <button type="submit">Add toy</button>
</form>
EOF
        );
        $fileBuilder->setEntryPointFilename('new_toy.php');

        $fileBuilder->addFileContents('functions.php', <<<EOF
<?php
function get_great_pet_toys()
{
    \$contents = file_get_contents('toys.json');
    \$toys = json_decode(\$contents, true);

    return \$toys;
}
EOF
        );

        $fileBuilder->addFileContents('toys.json', <<<EOF
[
    {
        "name": "Bacon Bone",
        "description": "What could be better?"
    },
    {
        "name": "Tennis Ball",
        "description": "Throw, fetch, throw, fetch, throw, fetch..."
    },
    {
        "name": "Frisbee",
        "description": "Go Deep!"
    }
]
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
        // TODO - add some form submit code!
        // toy_name = "Fluffy Pig Stuffed Animal"
        // description = "Your dog will *love* to chew and destroy this adorable pig!"
    }

    public function grade(CodingExecutionResult $result)
    {
        $result->assertOutputContains('Bacon Bone', '`var_dump() the file contents of `toys.json` after saving the new toy');
        $result->assertInputContains('new_toy.php', 'var_dump()', '`var_dump() the file contents of `toys.json` after saving the new toy');
        $result->assertInputContains('new_toy.php', 'file_get_contents', '`var_dump() the file contents of `toys.json` after saving the new toy');
        $result->assertOutputContains('Fluffy Pig Stuffed Animal', 'Did you add the submitted toy to the toys array before saving `toys.json`?');
        $result->assertInputContains('new_toy.php', 'get_great_pet_toys', 'Call `get_great_pet_toys()` first to get the existing toys');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('new_toy.php', <<<EOF
<?php
require 'functions.php';

\$name = \$_POST['name'];
\$description = \$_POST['description'];

\$toys = get_great_pet_toys();
\$toys[] = array('name' => \$name, 'description' => \$description);
\$json = json_encode(\$toys, JSON_PRETTY_PRINT);
file_put_contents('toys.json', \$json);

var_dump(file_get_contents('toys.json'));
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
