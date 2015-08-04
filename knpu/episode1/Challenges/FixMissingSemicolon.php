<?php

namespace Challenges;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class FixMissingSemicolon implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Poor devs. Management was so excited about variables that they
tried to edit the code themselves. We've send the dev team for
ice cream to make up for it. While they're gone, fix the errors
in this file for them.
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('index.php', <<<EOF

<?php
\$airpupTag = 'I <3 kittens'
\$yearFounded = 2015;

<h2>
    <?php echo \$airPupTag; ?> (founded <?php echo \$yearFonded; ?>)
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
        // sanity checks to make sure they didn't just clear the file
        // mostly, we want them to fix the errors
        $expected = 'I <3 kittens';
        $result->assertOutputContains($expected);
        $result->assertElementContains('h2', $expected);
        $result->assertElementContains('h2', 2015);
    }
}
