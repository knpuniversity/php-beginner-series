<?php

namespace Challenges\Arrays3;

use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class CountAndVariableReorderCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Using the `count` function, print the total number of pet toys
that we're selling in the `<h4>` tag.
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<h4>
    <!-- replace the XXXX with the real number of toys using count -->
    Selling XXXX Toys
</h4>

<?php
\$toys = array();
\$toys[] = array('name' => 'Bacon Bone', 'color' => 'Bacon-colored');
\$toys[] = array('name' => 'Tennis Ball', 'color' => 'Yellow');
\$toys[] = array('name' => 'Frisbee', 'color' => 'Red');
?>
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

        $phpGrader->assertInputContains('index.php', 'count');
        $htmlGrader->assertElementContains('h4', 3, 'I don\'t see the number 3 inside the `<h4>` tag. Are you printing the `count()` there?');
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

<h4>
    <!-- replace the XXXX with the real number of toys using count -->
    Selling <?php echo count(\$toys); ?> Toys
</h4>
EOF
        );
    }
}
