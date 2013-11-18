<?php

use KnpU\ActivityRunner\Result;

require __DIR__.'/../../shared/AbstractSuite.php';

class SetVarSuite extends AbstractSuite
{
    const EXPECTED = 'Hello World';

    public function runTest(Result $result)
    {
        $code = $result->getInput();
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);

        // 2) check for an echo statement
        $this->assertEchoExists($code);

        // 3) check for the $pageTitle variable
        $this->assertContains('$pageTitle', $code, 'I don\'t see your $pageTitle variable. Make sure you create a new variable called $pageTitle and set it to a string.');

        // 4) check for Hello World to be inside the code
        $this->assertContains(self::EXPECTED, $code, 'Are you printing "Hello World" - I don\'t see it!', true);

        // 5) Make sure Hello World is in the output
        $this->assertContains(self::EXPECTED, $output, 'Are you printing "Hello World" - I don\'t see it!', true);

        $h1 = $this->getCrawlerForSingleH1Element($output);

        // 6) Look for Hello World in the output inside the h1
        $this->assertNodeContainsText($h1, self::EXPECTED);
    }
}