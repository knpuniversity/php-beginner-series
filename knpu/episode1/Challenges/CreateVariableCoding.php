<?php

namespace Challenges;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class CreateVariableCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The management of AirPupnMeow is always changing its mind. To simplify
the life of our devs, let's use a variable so that when management
changes the tag line, we only have to update one spot. Create
a variable called `airpupTag` and set it to `I <3 kittens`. Then print
this inside the `<h2>` tag.
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();

        $fileBuilder->addFileContents('index.php', <<<EOF
<!-- create the variable here -->

<h2>
    <!-- print the variable here -->
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
        $expected = 'I <3 kittens';
        $result->assertOutputContains($expected);
        $result->assertElementContains('h2', $expected);
        $result->assertVariableEquals('airpupTag', $expected);
        $result->assertInputContains('index.php', 'echo');
    }
}
