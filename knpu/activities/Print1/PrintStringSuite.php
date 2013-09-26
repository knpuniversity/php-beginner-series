<?php

use KnpU\ActivityRunner\Assert\AssertSuite;

class PrintStringSuite extends AssertSuite
{
    const EXPECTED = 'Hello World';

    public function testActivity()
    {
        $code = $this->getInput();
        $output = $this->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertContains('<?php', $code, 'Don\'t forget to write <?php before writing PHP code.');

        // 2) check for an echo statement
        $this->assertContains('echo', $code, 'I don\'t see your "echo" statement. Did you remember to write "echo"?');

        // 3) check for Hello World to be inside the code
        $this->assertContains(self::EXPECTED, $code);

        $crawler = $this->getCrawler();

        // 4) Make sure Hello World is in the output
        $this->assertContains(self::EXPECTED, $output);

        // 5) Look for the h1
        $h1 = $crawler->filter('h1');
        $this->assertNotEquals(0, count($h1), 'I don\'t see your <h1> tag in the output - make sure you have <h1>Hello World</h1> in your final HTML');

        // 6) Look for Hello World in the output inside the h1
        $this->assertEquals(
            self::EXPECTED,
            $h1->text(),
            sprintf('I see your <h1> tag, but it has the wrong text in it. I see "%s"', $h1->text())
        );

        // case sensitivity?
        // put the h1 tag inside the body tag?
        /*
         * This currently passes
         *     <?php echo 'foo'; ?>
         *     <h1>Hello World</h1>
         */
    }
}