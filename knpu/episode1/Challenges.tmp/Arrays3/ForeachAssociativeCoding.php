<?php

namespace Challenges\Arrays3;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;


class ForeachAssociativeCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The site is *so* popular that we're adding a store that
sells the world's squeekiest dog toys. Using the `\$toys` 
array below, create a `foreach` statement and print each toy's 
`name` inside an `h3` tag and its `color` inside an `h4` tag. 
Avoid needing to echo the HTML tags by closing PHP at the end 
of the `foreach` line.
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<?php
\$toys = array();
\$toys[] = array('name' => 'Bacon Bone', 'color' => 'Bacon-colored');
\$toys[] = array('name' => 'Tennis Ball', 'color' => 'Yellow');
\$toys[] = array('name' => 'Frisbee', 'color' => 'Red');
?>

<!-- Add a foreach here -->
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
        $htmlGrader = new HtmlOutputGradingTool($result);

        $htmlGrader->assertElementContains('h3', 'Bacon Bone');
        $htmlGrader->assertElementContains('h3', 'Tennis Ball');
        $htmlGrader->assertElementContains('h4', 'Bacon-colored');
        $htmlGrader->assertElementContains('h4', 'Yellow');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
\$toys = array();
\$toys[] = array('name' => 'Bacon Bone', 'color' => 'Bacon-colored');
\$toys[] = array('name' => 'Tennis Ball', 'color' => 'Yellow');
\$toys[] = array('name' => 'Frisbee', 'color' => 'Red');
?>

<?php foreach (\$toys as \$toy) { ?>
    <h3><?php echo \$toy['name']; ?></h3>
    <h4><?php echo \$toy['color']; ?></h4>
<?php } ?>
EOF
        );
    }
}
