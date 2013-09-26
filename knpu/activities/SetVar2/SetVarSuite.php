<?php

use KnpU\ActivityRunner\Assert\AssertSuite;

require __DIR__.'/../Print1/PrintStringSuite.php';

class SetVarSuite extends PrintStringSuite
{
    public function testActivity()
    {
        parent::testActivity();

        $code = $this->getInput();

        // 1) check for an echo statement
        $this->assertContains('$pageTitle', $code, 'I don\'t see your "$pageTitle" variable. Did you remember to create and set it?');

        // should really look for a $pageTitle =
    }
}