<?php

namespace Challenges\Arrays2;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class AddNewKeyCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
We went to ancestry.com and have discovered Waggy Pig's breed:
`bichon`. Add a new `breed` key on a new line after the `\$waggyPig`
array has already been created. Print this new info below!
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
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
<div class="breed">
    <!-- print the bred here -->
</div>
<p>
    <?php echo \$waggyPig['bio']; ?>
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
        $result->assertVariableEquals('waggyPig[breed]', 'bichon');
        $result->assertInputContains(
            'index.php',
            '$waggyPig[', 'Add the `breed` key *after* the `$waggyPig` variable is created using the `[\'breed\']` syntax'
        );
        $result->assertElementContains('.breed', 'bichon');
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
\$waggyPig['breed'] = 'bichon';
?>

<h2><?php echo \$waggyPig['name']; ?></h2>
<div class="age"><?php echo \$waggyPig['age']; ?></div>
<div class="weight"><?php echo \$waggyPig['weight']; ?></div>
<div class="breed">
    <?php echo \$waggyPig['breed']; ?>
</div>
<p>
    <?php echo \$waggyPig['bio']; ?>
</p>
EOF
        );
    }
}
