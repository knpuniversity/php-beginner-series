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

        $this->assertEchoExists($code);

        $secondNode = $this->getCrawlerForSingleElement($output, '.second-thing', 'Did you delete the .second-thing div? I don\'t see it!', 'Make sure you only have 1 .second-thing div - I see more!');

        $this->assertContains('$things[', $code, 'Are you using the [] syntax to find the second item on the $things variable? I\'m expecting to see $things[###] where ### is some number, but I don\'t see it!');
        $this->assertContains('$things[1', $code, sprintf('Remember that you\'re looking or the second item, which is actually the array key 1'));
        $this->assertNodeContainsText($secondNode, 'high-fives');
    }
}