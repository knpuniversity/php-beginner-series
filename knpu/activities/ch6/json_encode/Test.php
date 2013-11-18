<?php

use KnpU\ActivityRunner\Result;

require __DIR__ . '/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput();
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);

        $this->assertEchoExists($code);

        $this->assertFunctionCallExists('json_encode', $code);

        $outputNode = $this->getCrawlerForSingleElement($output, '.json-output');
        $this->assertNodeContainsText($outputNode, '[{"name":"Pancake"');
    }
}
