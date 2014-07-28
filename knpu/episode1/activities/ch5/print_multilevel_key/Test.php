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

        $expectedCode = '$pets[1]';
        $this->assertContains(
            $expectedCode,
            $code,
            sprintf(
                'I expected to see %s[\'breed\'] being printed out, but I don\'t see this! Use this code to print out Spark Pug\'s breed!',
                $expectedCode
            )
        );
        $breedNode = $this->getCrawlerForSingleElement($output, '.spark-pug-breed');
        $this->assertNodeContainsText($breedNode, 'Pug');
    }
}
