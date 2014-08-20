<?php

use KnpU\ActivityRunner\Result;

require __DIR__ . '/shared/AbstractSuite.php';

class RedirectSuite extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput('pets_new.php');
        $output = $result->getOutput();

        // 1) Make sure we see the function
        $this->assertFunctionCallExists('header', $code);

        // 2) Check for the Location header
        $this->assertContains(
            'Location',
            $code,
            'Make sure you\'re setting the Location: header inside the header() function.'
        );

        // 3) Make sure the colon is there
        $this->assertContains(
            'Location:',
            $code,
            'Headers - like Location - need to have a colon between them and their value. Try "Location: /"'
        );
    }
}
