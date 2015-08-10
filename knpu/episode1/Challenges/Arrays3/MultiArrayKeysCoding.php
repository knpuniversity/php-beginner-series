<?php

namespace Challenges\Arrays3;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class MultiArrayKeysCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Access the bio on Pancake and print it inside the `<h1>` tag.
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF
<?php
\$pets = array(
    array('name' => 'Pico de Gato', 'bio' => 'Spicy kitty'),
);
\$pets[] = array('name' => 'Waggy Pig', 'bio' => 'Little white dog');
\$pets[] = array('name' => 'Pancake', 'bio' => 'Breakfast is my favorite!');
?>

<h1>
    <!-- Print Pancake's bio here -->
</h1>
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
        $result->assertInputContains(
            'index.php',
            "\$pets[2]['bio']"
        );
        $result->assertElementContains('h1', 'Breakfast is my favorite!');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
\$pets = array(
    array('name' => 'Pico de Gato', 'bio' => 'Spicy kitty'),
);
\$pets[] = array('name' => 'Waggy Pig', 'bio' => 'Little white dog');
\$pets[] = array('name' => 'Pancake', 'bio' => 'Breakfast is my favorite!');
?>

<h1>
    <?php echo \$pets[2]['bio']; ?>
</h1>
EOF
        );
    }
}
