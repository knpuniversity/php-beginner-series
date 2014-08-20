<?php

use KnpU\ActivityRunner\Result;

require __DIR__ . '/shared/AbstractSuite.php';

class CheckHttpMethodSuite extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput('pets_new.php');
        $output = $result->getOutput();

        // 1) Make sure we're referencing $_SERVER['REQUEST_METHOD']
        $this->assertContains(
            '$_SERVER',
            $code,
            'Make sure you\'re using the $_SERVER variable - I don\'t see this used anywhere!'
        );
        $this->assertContains(
            'REQUEST_METHOD',
            $code,
            'Inside $_SERVER, get the REQUEST_METHOD key and use it in an if statement'
        );

        // 4) Make sure we're dumping
        $this->assertFunctionCallExists('var_dump', $code);

        // 5) Make sure we see the filled-in name and bio dumping
        $this->assertContains(
            'Chew Barka',
            $output,
            'I don\'t see the submitted "name" POST value being printed. Make sure you have var_dump($_POST[\'name\'])'
        );
        $this->assertContains(
            'The park',
            $output,
            'I don\'t see the submitted "bio" POST value being printed. Make sure you have var_dump($_POST[\'bio\'])'
        );
    }
}
