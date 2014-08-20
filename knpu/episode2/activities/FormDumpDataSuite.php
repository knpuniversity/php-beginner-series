<?php

use KnpU\ActivityRunner\Result;

require __DIR__ . '/shared/AbstractSuite.php';

class FormDumpDataSuite extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput('pets_new.php');
        $output = $result->getOutput();

        // 1) make sure we have an text field with name="name"
        $nameInput = $this->getCrawlerForAtLeastOneElement(
            $output,
            'input[name="name"]',
            sprintf('I don\'t see the <input type="text" name="name"> element - make sure you add one!')
        );

        // 2) Make sure the bio textarea is there
        $bioInput = $this->getCrawlerForSingleElement(
            $output,
            'textarea',
            sprintf('I don\'t see a textarea element - make sure you add one!')
        );
        $this->assertEquals(
            'bio',
            $bioInput->attr('name'),
            sprintf('Make sure your textarea element has a name="bio"')
        );

        // 3) Make sure we're referencing $_POST
        $this->assertContains(
            '$_POST',
            $code,
            'Make sure you\'re using the $_POST variable to dump the name and bio keys! I don\'t see $_POST anywhere'
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
