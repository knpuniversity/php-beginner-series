<?php

use KnpU\ActivityRunner\Result;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    const EXPECTED = 'I\'m sorry, Dave. I\'m afraid I can\'t do that';

    public function runTest(Result $result)
    {
        $code = $result->getInput('index.php');
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);

        $this->assertContains(
            'function',
            $code,
            'I don\'t see any functions being created - write function hal_9000() to create the function.'
        );

        $this->assertContains(
            'function hal_9000',
            $code,
            'I see that you have a function, bit it doesn\'t look like it\'s named hal_9000!'
        );

        $this->assertContains(
            'return ',
            $code,
            'Make sure you have a `return` statement *inside* your function that returns the string.'
        );

        $this->assertEchoExists($code, 'Make sure you use `echo` when calling the function: `<?php echo hal_9000(); ?>`');

        $outputEl = $this->getCrawlerForSingleElement($output, '.output');
        $this->assertNodeContainsText($outputEl, self::EXPECTED);
    }
}
