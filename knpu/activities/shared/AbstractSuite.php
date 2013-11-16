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
     * @param string|Crawler $output
     * @param string $cssSelector
     * @param string $zeroError
     * @param string $moreThanOneError
     * @return Crawler
     */
    protected function getCrawlerForSingleElement($output, $cssSelector, $zeroError = null, $moreThanOneError = null)
    {
        $ele = $this->getCrawlerForAtLeastOneElement($output, $cssSelector, $zeroError);

        if ($moreThanOneError === null) {
            $moreThanOneError = sprintf('I expected only 1 "%s" element, but instead I see %s!', $cssSelector, count($ele));
        }

        $this->assertEquals(1, count($ele), $moreThanOneError);

        return $ele;
    }

    /**
     * Returns a Crawler from CSS and makes sure at least one is matched
     *
     * @param $output
     * @param $cssSelector
     * @param null $zeroError
     * @return Crawler
     */
    protected function getCrawlerForAtLeastOneElement($output, $cssSelector, $zeroError = null)
    {
        // the output could already be a Crawler
        if ($output instanceof Crawler) {
            $crawler = $output;
        } else {
            $crawler = $this->getCrawler($output);
        }

        $ele = $crawler->filter($cssSelector);

        if ($zeroError === null) {
            $zeroError = sprintf('Cannot find the "%s" element!', $cssSelector);
        }

        $this->assertNotEquals(0, count($ele), $zeroError);

        return $ele;
    }

    protected function assertNodeContainsText(Crawler $node, $expectedText, $ignoreCase = true, $message = null)
    {
        if ($message === null) {
            $message = 'I see your %tag% tag, but it has the wrong text in it. I see "%actual%" but I expected "%expected%"!';
        }

        if ($node->attr('class')) {
            $tag = '<%element.name% class="%element.class%">';
        } else {
            $tag = '<%element.name%>';
        }
        // replace the tag first, then the element.name/element.class can be replaced next
        $message = strtr($message, array(
            '%tag%' => $tag,
        ));

        $message = strtr($message, array(
            '%element.name%' => $this->getDomNode($node)->tagName,
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

    /**
     * @param Crawler $crawler
     * @return \DOMElement|null
     */
    protected function getDomNode(Crawler $crawler)
    {
        foreach ($crawler as $node) {
            return $node;
        }
    }
}