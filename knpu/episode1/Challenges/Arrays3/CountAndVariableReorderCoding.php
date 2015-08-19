<?php

namespace Challenges\Arrays3;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

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

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
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

    public function getExecutionMode()
    {
        return self::EXECUTION_MODE_PHP_NORMAL;
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $result->assertInputContains('index.php', 'count');
        $result->assertElementContains('h4', 3, 'I don\'t see the number 3 inside the `<h4>` tag. Are you printing the `count()` there?');
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
