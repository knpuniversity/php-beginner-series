<?php

use KnpU\ActivityRunner\Result;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    const EXPECTED = 'I\'m sorry, Dave. I\'m afraid I can\'t do that';

    public function runTest(Result $result)
    {
        $code1 = $result->getInput('page1.php');
        $code2 = $result->getInput('page2.php');
        $codeFunctions = $result->getInput('functions.php');
        // output of page2
        $output = $result->getOutput();

        // make sure we're not just requiring page1.php from page2.php
        $this->assertNotContains(
            'Page1',
            $output,
            'I see the HTML from page1.php inside page2.php. If you\'re requiring page1.php directly, you should instead move `hal_900` to functions.php and include that from both files.'
        );

        $this->assertRequireExists('functions.php', $code1, 'page1.php');
        $this->assertRequireExists('functions.php', $code2, 'page2.php');

        $this->assertFunctionDeclarationExists('hal_9000', $codeFunctions);

        // check for the output
        $outputEl = $this->getCrawlerForSingleElement($output, '.output');
        $this->assertNodeContainsText($outputEl, self::EXPECTED);
    }
}
