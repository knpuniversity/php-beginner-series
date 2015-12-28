<?php

namespace Challenges\CleaningUpWithSavedPets;

use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class RefactorToySavingCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Users are now able to enter new toys they want to sell and you're a hero in the office!
Put the finishing touches on this by reorganizing the toy-saving logic into a new function
called `save_toys()`. Be sure to call this function to keep things working!
EOF;
    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('new_toy.php', <<<EOF
<?php
require 'functions.php';

\$name = \$_POST['name'];
\$description = \$_POST['description'];

\$toys = get_great_pet_toys();
\$toys[] = array('name' => \$name, 'description' => \$description);
\$json = json_encode(\$toys, JSON_PRETTY_PRINT);
file_put_contents('toys.json', \$json);
?>

<form action="/new_toy.php" method="POST">
    <input type="text" name="name" />
    <textarea name="description"></textarea>

    <button type="submit">Add toy</button>
</form>
EOF
            )
            ->addFileContents('functions.php', <<<EOF
<?php
function get_great_pet_toys()
{
    \$contents = file_get_contents('toys.json');
    \$toys = json_decode(\$contents, true);

    return \$toys;
}
EOF
            )
            ->addFileContents('toys.json', <<<EOF
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
            )
            ->setEntryPointFilename('new_toy.php')
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

        $phpGrader->assertInputContains('functions.php', 'save_toys(', 'Put the `save_toys` function into `functions.php` for organization');
        $phpGrader->assertInputContains('new_toy.php', 'save_toys(', 'Be sure to call the `save_toys()` function from within `new_toy.php`');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('new_toy.php', <<<EOF
<?php
require 'functions.php';

\$name = \$_POST['name'];
\$description = \$_POST['description'];

\$toys = get_great_pet_toys();
\$toys[] = array('name' => \$name, 'description' => \$description);
save_toys(\$toys);
?>

<form action="/new_toy.php" method="POST">
    <input type="text" name="name" />
    <textarea name="description"></textarea>

    <button type="submit">Add toy</button>
</form>
EOF
            )
            ->setFileContents('functions.php', <<<EOF
<?php
function get_great_pet_toys()
{
    \$contents = file_get_contents('toys.json');
    \$toys = json_decode(\$contents, true);

    return \$toys;
}

function save_toys(\$toys)
{
    \$json = json_encode(\$toys, JSON_PRETTY_PRINT);
    file_put_contents('toys.json', \$json);
}
EOF
            )
        ;
    }
}
