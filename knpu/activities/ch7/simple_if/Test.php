<?php

use KnpU\ActivityRunner\Result;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    const EXPECTED = 'The breed is not shown';

    public function runTest(Result $result)
    {
        $code = $result->getInput('index.php');
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);
        $this->assertIfExists($code);

        $breedCrawler = $this->getCrawler($output)->filter('.pet-breed');

        $breedCrawler->each(function(Crawler $breedEl) {
            $text = trim($breedEl->text());
            // make sure none of these say simply "hidden"
            $this->assertNotContains(
                'hidden',
                $text,
                sprintf(<<<EOF
It looks like the "hidden" breed is being printed. Use an if statement to print "%s" instead.

 Remember to compare 2 values, use:

 `==` to see if two values are equal;
 `!=` to see if two values are not equal;
 `>` and `<` to see if one value is greater or less than another value.
EOF
                , self::EXPECTED)
            );
        });

        $this->assertContains('Bichon', $output, 'I don\'t see Chew Barka\'s breed (Bichon) being printed anymore. Check your if statement to make sure it\'s still printing the breed, except when it\'s equal to `hidden`.');
        $this->assertContains(self::EXPECTED, $output, sprintf('I did not see the text "%s" - make sure you\'re printing it out when the breed key equals `hidden`', self::EXPECTED));
    }
}
