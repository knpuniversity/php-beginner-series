<?php

use KnpU\ActivityRunner\Result;

require __DIR__ . '/shared/AbstractSuite.php';

class SaveToFileSuite extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput('pets_new.php');
        $output = $result->getOutput();

        // 1) Make sure we have json_encode
        $this->assertFunctionCallExists('json_encode', $code);

        // 2) Make sure we have file_put_contents
        $this->assertFunctionCallExists('file_put_contents', $code);

        // 3) Check for new_pet.json
        $finalFiles = $result->getFinalFileContents();
        if (!isset($finalFiles['new_pet.json'])) {
            $this->fail('Hmm, I don\'t see a new_pet.json. Did you use file_put_contents to create it?');
        }

        // 4) Basic validation on new_pet.json contents
        $savedPets = json_decode($finalFiles['new_pet.json'], true);
        if (!$savedPets) {
            $this->fail('I see new_pet.json, but it doesn\'t look like it holds a valid JSON string :/.');
        }
    }
}
