<?php

namespace Challenges\FilesJsonBooleans;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

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

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<!-- save the doglife.txt file -->

<h2>
    <!-- print the doglife.txt contents here -->
</h2>
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
        $result->assertInputContains('index.php', 'file_put_contents');
        $result->assertInputContains('index.php', 'doglife.txt');
        $result->assertInputContains('index.php', 'Dogs rule!');
        $result->assertInputContains('index.php', 'file_get_contents');

        $result->assertElementContains('h2', 'Dogs rule!');
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
