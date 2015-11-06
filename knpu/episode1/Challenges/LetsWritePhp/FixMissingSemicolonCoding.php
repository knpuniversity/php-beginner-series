<?php

namespace Challenges\LetsWritePhp;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class FixMissingSemicolonCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Poor devs. Management was so excited about variables that they
tried to edit the code themselves. We've sent the dev team for
ice cream to make up for it. While they're gone, fix the errors
in this file for them.
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF

<?php
\$airpupTag = 'I luv kittens'
\$yearFounded = 2015;

<h2>
    <?php echo \$airpupTag; ?> (founded <?php echo \$yearFonded; ?>)
</h2>
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
//        $phpGrader = new PhpGradingTool($result);
        $htmlGrader = new HtmlOutputGradingTool($result);

        // sanity checks to make sure they didn't just clear the file
        // mostly, we want them to fix the errors
        $expected = 'I luv kittens';
        $htmlGrader->assertOutputContains($expected);
        $htmlGrader->assertElementContains('h2', $expected);
        $htmlGrader->assertElementContains('h2', 2015);
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
\$airpupTag = 'I luv kittens';
\$yearFounded = 2015;
?>

<h2>
    <?php echo \$airpupTag; ?> (founded <?php echo \$yearFounded; ?>)
</h2>
EOF
        );
    }
}
