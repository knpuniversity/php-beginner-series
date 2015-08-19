<?php

namespace Challenges\Arrays2;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class ConvertToAssociativeCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Our favorite pet - Waggy Pig - is a cute white silly dog. Update
the code below to use an associative array: set they keys of the array
to `name`, `weight`, `age` and `bio`. Then, update the code below so
Waggy Pig's bio still prints out!
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<?php
\$waggyPig = array('Waggy Pig', 10, 7, 'Sleepy white fluffy dog');
?>

<h2><?php echo \$waggyPig[0]; ?></h2>
<div class="age"><?php echo \$waggyPig[2]; ?></div>
<div class="weight"><?php echo \$waggyPig[1]; ?></div>
<p>
    <?php echo \$waggyPig[3]; ?>
</p>
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
        $result->assertVariableEquals('waggyPig', array(
            'name' => 'Waggy Pig',
            'weight' => 10,
            'age' => 7,
            'bio' => 'Sleepy white fluffy dog'
        ));
        $result->assertElementContains('h2', 'Waggy Pig');

        // help them out - I reversed the order on the elements
        if ($result->getElementText('.age') == '10') {
            throw new GradingException(
                'Careful! Be sure to print the `age` key in the `.age` element and the
                `weight` key in the `.weight` element. You might have them reversed.'
            );
        }
        $result->assertElementContains('.age', 7);
        $result->assertElementContains('.weight', 10);
        $result->assertElementContains('p', 'Sleepy white fluffy dog');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
\$waggyPig = array(
    'name' => 'Waggy Pig',
    'weight' => 10,
    'age' => 7,
    'bio' => 'Sleepy white fluffy dog'
);
?>

<h2><?php echo \$waggyPig['name']; ?></h2>
<div class="age"><?php echo \$waggyPig['age']; ?></div>
<div class="weight"><?php echo \$waggyPig['weight']; ?></div>
<p>
    <?php echo \$waggyPig['bio']; ?>
</p>
EOF
        );
    }
}
