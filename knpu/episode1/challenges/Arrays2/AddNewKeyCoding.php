<?php

namespace Challenges\Arrays2;

use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

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

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
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

    public function getWorkerConfig(WorkerLoaderInterface $loader)
    {
        return $loader->load(__DIR__.'/../php_worker.yml');
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $phpGrader = new PhpGradingTool($result);
        $htmlGrader = new HtmlOutputGradingTool($result);

        $waggyPig = $result->getDeclaredVariableValue('waggyPig');
        if (!array_key_exists('breed', $waggyPig)) {
            throw new GradingException('The $waggyPig variable doesn\'t have a `breed` key!');
        }
        if ($waggyPig['breed'] != 'bichon') {
            throw new GradingException(sprintf(
                'The $waggyPig[\'breed\'] key is equal to "%s" - but it should be equal to "bichon"',
                $waggyPig['breed']
            ));
        }

        $phpGrader->assertInputContains(
            'index.php',
            '$waggyPig[', 'Add the `breed` key *after* the `$waggyPig` variable is created using the `[\'breed\']` syntax'
        );
        $htmlGrader->assertElementContains('.breed', 'bichon');
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
