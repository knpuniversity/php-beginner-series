<?php

use KnpU\ActivityRunner\Result;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__.'/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput();
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);

        // 2) check for an echo statement
        $this->assertForeachExists($code);
        $this->assertEchoExists($code);

        $output = $this->getCrawler($output);
        $lis = $output->filter('li.my-favorite');

        // in case they left the original 3, hardcoded li elements
        if (count($lis) == 6) {
            $this->fail('I see 6 li elements, but there should only be 3. Did you maybe forget to remove the original 3 li elements you started with? They\'re dynamic now, so we don\'t need them.');
        }

        $this->assertEquals(3, count($lis), sprintf(
            'There should be 3 li elements with a "my-favorite" tag, but I see "%s"', count($lis)
        ));

        $expectedFavoriteThings = array('ice cream', 'high-fives', 'vacation');
        $lis->each(function ($node, $i) use ($expectedFavoriteThings) {
            // Symfony 2.2 versus 2.3 compatability
            if (!$node instanceof Crawler) {
                $node = new Crawler($node);
            }

            if (!in_array(strtolower($node->text()), $expectedFavoriteThings)) {
                $this->fail(sprintf(
                    'I found "%s" in the li elements, but it\'s not one of my favorite things! I like "%s"',
                    $node->text(),
                    implode(', ', $expectedFavoriteThings)
                ));
            }
        });
    }
}