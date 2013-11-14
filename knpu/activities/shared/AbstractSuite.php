<?php

use KnpU\ActivityRunner\Assert\PhpAwareSuite;
use Symfony\Component\DomCrawler\Crawler;

abstract class AbstractSuite extends PhpAwareSuite
{
    protected function assertPhpTagExists($code)
    {
        $this->assertContains('<?php', $code, 'Don\'t forget to write <?php before writing PHP code.');
    }

    protected function assertEchoExists($code)
    {
        $this->assertContains('echo', $code, 'I don\'t see your "echo" statement. Did you remember to write "echo"?');
    }

    protected function assertForeachExists($code)
    {
        $this->assertContains('foreach', $code, 'I don\'t see your "foreach" statement. Did you remember to write "foreach"?');
    }

    protected function assertVariableExists($variableName, $code)
    {
        $this->assertContains('$'.$variableName, $code, sprintf('I don\'t see the variable "%s". Did you remember to create it?', $variableName));
    }

    protected function assertStringExists($string, $code, $message = null)
    {
        if (stripos($code, "'".$string."'") === false && stripos($code, '"'.$string.'"') === false) {
            if ($message === null) {
                $message = sprintf('I don\'t see a string that\'s set to "%s"', $string);
            }

            $this->fail($message);
        }
    }

    protected function assertFunctionCallExists($functionName, $code)
    {
        $this->assertContains(
            $functionName,
            $code,
            sprintf('I don\'t see the %s function being called. Did you remember to write "%s"?', $functionName, $functionName
        ));
    }

    /**
     * Returns the Crawler for the single h1 element
     *
     * @param $output
     * @return Crawler
     */
    protected function getCrawlerForSingleH1Element($output)
    {
        return $this->getCrawlerForSingleElement(
            $output,
            'h1',
            'I don\'t see your <h1> in the output - make sure you have <h1>Hello World</h1> in your final HTML',
            'I see more than 1 h1 tag - just create one <h1></h1> pair and print Hello World inside of it'
        );
    }

    /**
     * Returns the Crawler for the single h1 element
     *
     * @param string $output
     * @param string $cssSelector
     * @param string $zeroError
     * @param string $moreThanOneError
     * @return Crawler
     */
    protected function getCrawlerForSingleElement($output, $cssSelector, $zeroError, $moreThanOneError)
    {
        $crawler = $this->getCrawler($output);
        $ele = $crawler->filter($cssSelector);
        $this->assertNotEquals(0, count($ele), $zeroError);
        $this->assertEquals(1, count($ele), $moreThanOneError);

        return $ele;
    }

    protected function assertNodeContainsText(Crawler $node, $expectedText, $ignoreCase = true, $message = null)
    {
        if ($message === null) {
            $message = 'I see your <%element.name%> tag, but it has the wrong text in it. I see "%actual%"';
        }

        $message = strtr($message, array(
            '%element.name%' => $node->current() ? $node->current()->nodeName : '',
            '%element.class%' => $node->attr('class'),
            '%expected%' => $expectedText,
            '%actual%' => $node->text()
        ));

        $this->assertContains(
            $expectedText,
            $node->text(),
            $message,
            $ignoreCase
        );
    }

    protected function assertNodeEqualsText(Crawler $node, $expectedText, $ignoreCase = true)
    {
        $this->assertEquals(
            $expectedText,
            $node->text(),
            sprintf('I see your <%s> tag, but it has the wrong text in it. I see "%s"', $node->current()->nodeName, $node->text()),
            // next 3 are just defaults
            0,
            10,
            false,
            $ignoreCase
        );
    }
}