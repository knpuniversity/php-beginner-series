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
prove it's working, read the file again with `file_get_contents()` and `var_dump()`
that JSON string.

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
        $request = $context->fakeHttpRequest('/new_toy.php', 'POST');
        $request->setPOSTData(array(
            'name' => 'Fluffy Pig Stuffed Animal',
            'description' => 'Your dog will *love* to chew and destroy this adorable pig!'
        ));
    }

    public function grade(CodingExecutionResult $result)
    {
        $result->assertInputContains('new_toy.php', 'json_encode', 'Use `json_encode()` in `new_toy.php` to encode the toys array before saving it');
        $result->assertInputContains('new_toy.php', 'file_put_contents', 'Use `file_put_contents()` in `new_toy.php` to save the new JSON string');
        $result->assertInputContains('new_toy.php', 'var_dump', '`var_dump()` the file contents of `toys.json` after saving the new toy');

        $result->assertInputContains('new_toy.php', 'get_great_pet_toys', 'Call `get_great_pet_toys()` first to get the existing toys');
        $result->assertOutputContains('Bacon Bone', 'I don\'t see `Bacon Bone` in `toys.json` - double-check that you\'re keeping the original pets, not replacing them entirely.');
        $result->assertOutputContains('Fluffy Pig Stuffed Animal', 'I don\'t see the new "Fluffy Pig" toy in `toys.json`. Are you adding it to the toys array before calling `json_encode()` and saving the file?');
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
