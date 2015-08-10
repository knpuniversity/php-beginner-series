<?php

namespace Challenges\Arrays3;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class ForeachAssociativeCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The site is *so* popular that we're adding a store that
sells dog toys. Using the `\$toys` array below, create a
`foreach` statement and print each toy's `name` inside an
`h3` tag and its `color` inside an `h4` tag. Avoid needing
to echo the HTML tags by closing PHP at the end of the `foreach`
line.
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
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

    public function getExecutionMode()
    {
        return self::EXECUTION_MODE_PHP_NORMAL;
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $result->assertElementContains('h3', 'Back Bone');
        $result->assertElementContains('h3', 'Tennis Ball');
        $result->assertElementContains('h4', 'Bacon-colored');
        $result->assertElementContains('h4', 'Yellow');
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
