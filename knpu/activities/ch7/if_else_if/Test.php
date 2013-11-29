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
        $this->assertElseIfExists($code);

        $this->assertContains(
            'Chew Barka',
            $output,
            'I don\'t see "Chew Barka" - his name is more than 8 characters, so it should be printed!'
        );
        $this->assertContains(
            'Pico de Gato',
            $output,
            'I don\'t see "Pico de Gato" - his name is more than 8 characters, so it should be printed!'
        );
        $this->assertContains(
            'Hey Sparky!',
            $output,
            'I don\'t see "Hey Sparky!" - we should print this instead of printing Spark Pug\'s actual name'
        );
        $this->assertNotContains(
            'Spark Pug',
            $output,
            'I see "Spark Pug", but his name shouldn\'t be printed! Instead, we should only print "Hey Spark!" in place of Spark Pug\'s name.'
        );
        $this->assertContains(
            'Short name',
            $output,
            'I don\'t see "Short name" but I should! Since Pancake\'s name is less than 8 characters, we should print "Short name" instead of Pancake.'
        );
        $this->assertNotContains(
            'Pancake',
            $output,
            'I see "Pancake" but I shouldn\'t! Since Pancake\'s name is less than 8 characters, we should print "Short name" instead of Pancake.'
        );
        $shortNameCount = substr_count($output, 'Short name');
        $this->assertEquals(1, $shortNameCount, sprintf('I see "Short name" %s times, but we should only see it once since there is only one pet name less than 8 characters!', $shortNameCount));
    }
}
