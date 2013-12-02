<?php

use KnpU\ActivityRunner\Result;
use Symfony\Component\DomCrawler\Crawler;

require __DIR__ . '/../../shared/AbstractSuite.php';

class Test extends AbstractSuite
{
    const EXPECTED_FEISTY = 'Pets with long names are feisty';

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
        $this->assertNotContains(
            'Pico de Gato',
            $output,
            'I see "Pico de Gato", but his name is 12 characters long, which means we should be printing "'.self::EXPECTED_FEISTY.'" instead!'
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
            'Pancake',
            $output,
            'I don\'t see "Pancake" but I should, since Pancake\'s name is only 7 characters long.'
        );
        $feistyCount = substr_count($output, self::EXPECTED_FEISTY);
        $this->assertEquals(1, $feistyCount, sprintf('I see "%s" %s times, but we should only see it once since there is only one pet name more than 11 characters!', self::EXPECTED_FEISTY, $feistyCount));
    }
}
