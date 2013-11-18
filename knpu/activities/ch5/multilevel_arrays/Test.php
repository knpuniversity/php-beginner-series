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
        $this->assertVariableExists('pets', $code);
        $this->assertForeachExists($code);

        // make sure that we only have class="pet" once in the code - since we're using foreach
        $petClassCount = substr_count($code, 'class="pet"');
        if ($petClassCount == 0) {
            $this->fail('I don\'t see the <div class="pet"> element. Did you delete it? You\'ll need this and the code inside of it to print your pets.');
        } elseif ($petClassCount > 1) {
            $this->fail(sprintf('We only need 1 <div class="pet"> element, but I see %s! If we place this HTML inside the `foreach` statement, we can print 3 pets without duplicating the HTML!', $petClassCount));
        }

        // duplicated in ch6/json_decode
        $petElement = $this->getCrawler($output)->filter('.pet');
        if (count($petElement) != 3) {
            $msg = sprintf('I expected to see 3 "div.pet" tags in the output, but I see "%s".', count($petElement));
            if (count($petElement) == 0) {
                $msg .= ' Did you delete the pet HTML code that was there in the beginning? If so, refresh and *use* that code to print out the 3 pets';
            }
            $this->fail($msg);
        }

        $nameNode = $this->getCrawlerForAtLeastOneElement($petElement, '.pet-name');
        $ageNode = $this->getCrawlerForAtLeastOneElement($petElement, '.pet-age');
        $breedNode = $this->getCrawlerForAtLeastOneElement($petElement, '.pet-breed');

        $this->assertNodeContainsText(
            $nameNode,
            'Pancake',
            true,
            'I expected to see "%expected%" as the value of the %element.name%.%element.class% element, but instead I see "%actual%". Check to see that you\'re printing out the "name" key correctly inside your `foreach` statement'
        );
        $this->assertNodeContainsText($ageNode, '1 year');
        $this->assertNodeContainsText($breedNode, 'Bulldog');
    }
}
