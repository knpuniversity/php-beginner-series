<?php

use KnpU\ActivityRunner\Result;

require __DIR__ . '/shared/AbstractSuite.php';

class RefactorFunctionSuite extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput('pets_new.php');
        $functionsCode = $result->getInput('lib/functions.php');
        $output = $result->getOutput();

        // 1) Make sure we're calling the function from pets_new.php
        $this->assertFunctionCallExists('save_new_pet', $code);

        // 2) Make sure we have json_encode
        $this->assertFunctionCallExists('json_encode', $functionsCode, 'I don\'t see json_encode being called from within the save_new_pet() function.');

        // 3) Make sure we have file_put_contents
        $this->assertFunctionCallExists('file_put_contents', $functionsCode, 'I don\'t see json_encode being called from within the file_put_contents() function.');

        // 4) Check for new_pet.json
        $finalFiles = $result->getFinalFileContents();
        if (!isset($finalFiles['new_pet.json'])) {
            $this->fail('Hmm, I don\'t see a new_pet.json. Did you use file_put_contents to create it?');
        }

        // 5) Basic validation on new_pet.json contents
        $savedPets = json_decode($finalFiles['new_pet.json'], true);
        if (!$savedPets) {
            $this->fail('I see new_pet.json, but it doesn\'t look like it holds a valid JSON string :/.');
        }

        // 6) Make sure the old stuff isn't still in pets_new.php
        $this->assertNotContains(
            'json_encode',
            $code,
            'You can remove json_encode from pets_new.php now that you\'re calling save_new_pet();'
        );
        $this->assertNotContains(
            'file_put_contents',
            $code,
            'You can remove file_put_contents from pets_new.php now that you\'re calling save_new_pet();'
        );
    }
}
