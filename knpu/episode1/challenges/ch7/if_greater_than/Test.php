<?php

use KnpU\ActivityRunner\Result;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput('index.php');
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);
        $this->assertIfExists($code);

        $this->getCrawlerForSingleElement(
            $output,
            '.pet-weight:contains("HUGE")',
            'I don\'t see the word HUGE inside any div.pet-weight elements. Are you printing this when the pet is kinda fat?',
            'I see HUGE %count% times, but only 1 Bulldog has a weight greater than 20. Are you checking the weight AND the breed?'
        );
    }
}
