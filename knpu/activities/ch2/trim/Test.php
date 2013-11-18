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

        $this->assertFunctionCallExists('trim', $code);

        $originalCode = '\'  Hello World \'';
        $this->assertContains($originalCode, $code, sprintf('Remove the whitespace without changing the `$pageTitle` variable - make sure it says `%s`.', $originalCode));

        $h1 = $this->getCrawlerForSingleH1Element($output);
        // this is what it is originally
        $this->assertNotEquals('  Hello World ', 'Be sure to use the trim() function in your echo statement to remove the extra whitespace!');
        $this->assertNodeEqualsText($h1, 'Hello World');
    }
}