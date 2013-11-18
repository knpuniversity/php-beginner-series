<?php

use KnpU\ActivityRunner\Result;

require __DIR__.'/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    const EXPECTED = 'I think dogs are AWESOME';

    public function runTest(Result $result)
    {
        // the concatenation converts it to a string for comparison later
        $length = ''.strlen(self::EXPECTED);

        $code = $result->getInput();
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);

        // 2) check for an echo statement
        $this->assertEchoExists($code);

        $this->assertFunctionCallExists('strip_tags', $code);
        $this->assertFunctionCallExists('strlen', $code);

        $element = $this->getCrawlerForSingleElement($output, '.comment-length', 'Did you delete the <div class="comment-length"> element?', 'Be sure to only have one element with a comment-length string!');
        $this->assertNodeContainsText($element, $length);
    }
}