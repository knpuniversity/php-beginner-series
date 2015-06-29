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

        $errorTemplate = "I don't see the array key called \"%s\". Use the '%s' => '%s' syntax inside an array to give an item a key";
        $this->assertStringExists('name', $code, sprintf($errorTemplate, 'name', 'name', 'Pancake'));
        $this->assertStringExists('age', $code, sprintf($errorTemplate, 'age', 'age', '1 year'));

        $nameNode = $this->getCrawlerForSingleElement($output, '.pet-name', 'Did you delete the .pet-name div? I don\'t see it!', 'Make sure you only have 1 .pet-name div - I see more!');
        $ageNode = $this->getCrawlerForSingleElement($output, '.pet-age', 'Did you delete the .pet-age div? I don\'t see it!', 'Make sure you only have 1 .pet-age div - I see more!');

        $this->assertNodeContainsText($nameNode, 'Pancake');
        $this->assertNodeContainsText($ageNode, '1 year');
    }
}
