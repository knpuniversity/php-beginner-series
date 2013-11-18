<?php

use KnpU\ActivityRunner\Result;

require __DIR__.'/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    const EXPECTED = '50';

    public function runTest(Result $result)
    {
        $code = $result->getInput();
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);

        // 2) check for an echo statement
        $this->assertEchoExists($code);

        // 3) check for the $pageTitle variable
        $this->assertContains('$pupCount', $code, 'I don\'t see your $pupCount variable. Make sure you create a new variable called $pupCount and set it to the number 50.');

        // 4) check for 50 to be inside the code
        $this->assertContains(self::EXPECTED, $code, 'Are you printing 50 - I don\'t see it!', true);

        // 5) Make sure 50 is in the output
        $this->assertContains(self::EXPECTED, $output, 'Are you printing 50 - I don\'t see it!', true);

        $ele = $this->getCrawlerForSingleElement(
            $output,
            '.count',
            'I don\'t see any element with the "count" class - make sure you have a <div class="count"> element!',
            'I see more than one element with the "count" class - make sure you have just one <div class="count"> element!'
        );

        // 6) Look for Hello World in the output inside the .count tag
        $this->assertNodeContainsText($ele, self::EXPECTED);
    }
}