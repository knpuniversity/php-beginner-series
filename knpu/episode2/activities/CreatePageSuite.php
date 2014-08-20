<?php

use KnpU\ActivityRunner\Result;

require __DIR__ . '/shared/AbstractSuite.php';

class CreatePageSuite extends AbstractSuite
{
    public function runTest(Result $result)
    {
        $code = $result->getInput('pets_new.php');
        $output = $result->getOutput();

        // 1) Check for opening an opening PHP tag!
        $this->assertPhpTagExists($code);

        // 2) Make sure there are some require tags
        $this->assertFunctionCallExists('require', $code);

        // 3) Check for the header
        $this->getCrawlerForSingleElement(
            $output,
            'title',
            'I don\'t see the header HTML. Did you require the layout/header.php file?'
        );

        // 4) Check for the footer
        $this->getCrawlerForSingleElement(
            $output,
            'footer',
            'I don\'t see the footer HTML. Did you require the layout/footer.php file?'
        );

        // 5) Check for the <h1> - don't use crawler, as it could be in the wrong spot
        $this->assertContains(
            '<h1',
            $output,
            'I don\'t see any h1 elements. Add an <h1> element between the header and the footer'
        );

        // 6) Check for the h1 element via the crawler - guarantees it's not after the footer
        $this->getCrawlerForAtLeastOneElement(
            $output,
            'h1',
            'I see the h1 element, but it doesn\'t look like it\'s inside a body tag :/. Make sure the <h1> element is being printed between the header and the footer'
        );

        // 7) Make sure the h1 isn't before the header
        $headPos = strpos($output,'<head');
        $h1Pos = strpos($output, '<h1');
        if ($headPos === false || $h1Pos === false) {
            // this shouldn't happen, because we're checking above
            // but if it does, it's our mistake, so let's let the test pass
            return;
        }

        $this->assertGreaterThan(
            $headPos,
            $h1Pos,
            'I see the h1 element, but it looks like it\'s before the header. Make sure to include the <h1> element between the header and the footer'
        );
    }
}
