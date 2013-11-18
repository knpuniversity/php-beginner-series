<?php

use KnpU\ActivityRunner\Result;

require __DIR__.'/../../shared/AbstractSuite.php';

class PrintStringSuite extends AbstractSuite
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

        // 3) check for Hello World to be inside the code
        $this->assertContains(self::EXPECTED, $code, 'Are you printing "Hello World" - I don\'t see it!', true);

        // 4) Make sure Hello World is in the output
        $this->assertContains(self::EXPECTED, $output, 'Are you printing "Hello World" - I don\'t see it!', true);

        $h1 = $this->getCrawlerForSingleH1Element($output);

        // 5) Look for Hello World in the output inside the h1
        $this->assertNodeContainsText($h1, self::EXPECTED);

        // put the h1 tag inside the body tag?
        /*
         * This currently passes
         *     <?php echo 'foo'; ?>
         *     <h1>Hello World</h1>
         */
    }
}