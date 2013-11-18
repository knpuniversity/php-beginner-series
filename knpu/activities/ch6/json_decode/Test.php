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
        $this->assertFunctionCallExists('json_decode', $code);
        $this->assertNotContains('$pets = array(', $code, sprintf('I still see that the $pets variable is being created manually. We don\'t need this anymore - use json_decode and pass it the contents of pets.json. This is an array, which we can set to $pets'));

        // If you forget the "true" as the 2nd argument to json_decode, you will get:
        // Cannot use object of type stdClass as array
        // but this will cause a fatal error, which results in our validator not being called :/
        // see https://github.com/knpuniversity/activity-runner/issues/2 item 4

        // duplicated in ch5/multilevel_arrays
        $petElement = $this->getCrawler($output)->filter('.pet');
        if (count($petElement) != 4) {
            $msg = sprintf('I expected to see 4 "div.pet" tags in the output, but I see "%s".', count($petElement));
            if (count($petElement) == 0) {
                $msg .= ' Did you delete the pet HTML code that was there in the beginning? If so, refresh and *use* that code to print out the 3 pets';
            }
            $this->fail($msg);
        }
    }
}
