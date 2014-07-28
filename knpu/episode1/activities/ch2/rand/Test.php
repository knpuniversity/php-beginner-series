<?php

use KnpU\ActivityRunner\Result;

require __DIR__.'/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput();
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);

        // 2) check for an echo statement
        $this->assertEchoExists($code);

        $this->assertFunctionCallExists('rand', $code);

        // 3) check for the $pageTitle variable
        $this->assertContains('$pupCount', $code, 'I don\'t see your $pupCount variable. Make sure you create a variable called $pupCount and assign it to the rand() function.');

        $ele = $this->getCrawlerForSingleElement(
            $output,
            '.count',
            'I don\'t see any element with the "count" class - make sure you have a <div class="count"> element!',
            'I see more than one element with the "count" class - make sure you have just one <div class="count"> element!'
        );

        $contents = $ele->text();
        $this->assertGreaterThanOrEqual(10, $contents, 'Are you printing a random number that is at least 10?');
        $this->assertLessThanOrEqual(20, $contents, 'Are you printing a random number that is 20 or lower?');
    }
}