<?php

use KnpU\ActivityRunner\Result;

require __DIR__.'/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput();
        $output = $result->getOutput();

        $this->assertPhpTagExists($code);

        $this->assertEchoExists($code);

        $errorTemplate = "I don't see the array key called \"%s\". Use the '%s' => '%s' syntax inside an array to give an item a key";
        $this->assertStringExists('breed', $code, sprintf($errorTemplate, 'breed', 'breed', 'Pug'));

        $expected = "\$pancake['breed'] = 'Pug'";
        // find the assignment, with fuzzy spaces around the =
        $regex = '#\$pancake\[\'breed\'\]\s*=#';
        $this->assertRegExp(
            $regex,
            $code,
            sprintf('For this activity, see if you can add the new "breed" key on a new line after the array is originally created (%s)', $expected)
        );

        $breedNode = $this->getCrawlerForSingleElement($output, '.pet-breed', 'Did you delete the .pet-breed div? I don\'t see it!', 'Make sure you only have 1 .pet-breed div - I see more!');

        $this->assertNodeContainsText($breedNode, 'Pug');
    }
}
