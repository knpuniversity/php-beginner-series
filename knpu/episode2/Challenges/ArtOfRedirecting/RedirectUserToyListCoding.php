<?php

namespace Challenges\ArtOfRedirecting;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class RedirectUserToyListCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
Suppose you originally had a page called `/aboutUs.php`, but decided to rename it
to `/about.php`. Simple: you rename the file, and you're done! Unfortunately, a lot
of other sites are still linking to `/aboutUs.php`, and any user clicking those links
are getting an error.

So, you decide to re-create `aboutUs.php`, and just make it redirect to `/about.php`.
Fill in the logic to redirect to `/about.php`.

**Note**: You won't see any output, because redirects actually return a blank response.
In the real world, your browser would quickly make a second request to `about.php`
(and you'd see that page).
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();
        $fileBuilder->addFileContents('aboutUs.php', <<<EOF

EOF
        );
        $fileBuilder->setEntryPointFilename('aboutUs.php');

        $fileBuilder->addFileContents('about.php', <<<EOF
<h1>Yea! About us!</h1>
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
        $context->fakeHttpRequest('GET', '/aboutUs.php');
    }

    public function grade(CodingExecutionResult $result)
    {
        $result->assertInputContains('aboutUs.php', 'header(', 'Use the `header()` function to redirect');
        $result->assertInputContains('aboutUs.php', 'Location:', 'Set the `Location:` header to `/about.php`');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('aboutUs.php', <<<EOF
<?php
// this is extra credit: a 301 redirect is good for search engines in this case!
http_response_code(301);

header('Location: /about.php');
EOF
        );
    }
}
