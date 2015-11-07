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

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
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

        $phpGrader->assertVariableEquals('waggyPig', array(
            'name' => 'Waggy Pig',
            'weight' => 10,
            'age' => 7,
            'bio' => 'Sleepy white fluffy dog'
        ));
        $htmlGrader->assertElementContains('h2', 'Waggy Pig');

        // help them out - I reversed the order on the elements
        if ($htmlGrader->getElementText('.age') == '10') {
            throw new GradingException(
                'Careful! Be sure to print the `age` key in the `.age` element and the
                `weight` key in the `.weight` element. You might have them reversed.'
            );
        }
        $htmlGrader->assertElementContains('.age', 7);
        $htmlGrader->assertElementContains('.weight', 10);
        $htmlGrader->assertElementContains('p', 'Sleepy white fluffy dog');
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
