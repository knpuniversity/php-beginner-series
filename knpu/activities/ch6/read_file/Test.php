<?php

use KnpU\ActivityRunner\Result;

require __DIR__ . '/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput('index.php');
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);

        $this->assertEchoExists($code);
        $this->assertFunctionCallExists('file_get_contents', $code);

        $outputNode = $this->getCrawlerForSingleElement($output, '.file-contents');
        $this->assertNodeContainsText($outputNode, '"name"');
        $this->assertNodeContainsText($outputNode, '"Chew Barka"');
    }
}
