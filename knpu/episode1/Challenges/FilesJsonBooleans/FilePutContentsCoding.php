<?php

namespace Challenges\FilesJsonBooleans;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class FilePutContentsCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
We're going to totally troll the cats on the site,
use `file_put_contents` to save the text `Dogs rule!` into a
new file called `doglife.txt`. Then read that file and print
the string into the `<h2>` tag
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<!-- save the doglife.txt file -->

<h2>
    <!-- print the doglife.txt contents here -->
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
        $phpGrader = new PhpGradingTool($result);
        $htmlGrader = new HtmlOutputGradingTool($result);

        $phpGrader->assertInputContains('index.php', 'file_put_contents');
        $phpGrader->assertInputContains('index.php', 'doglife.txt');
        $phpGrader->assertInputContains('index.php', 'Dogs rule!');
        $phpGrader->assertInputContains('index.php', 'file_get_contents');

        $htmlGrader->assertElementContains('h2', 'Dogs rule!');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
    file_put_contents('doglife.txt', 'Dogs rule!');
?>

<h2>
    <?php echo file_get_contents('doglife.txt'); ?>
</h2>
EOF
        );
    }
}
