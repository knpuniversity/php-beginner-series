<?php

namespace Challenges\SystemSetup;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class LocalhostPortFilenameMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Suppose I put `http://localhost:8000` into my browser. Which of the following is true:
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('The request cannot be completed because there is no filename (e.g. `index.php`) in the URL')
            ->addAnswer('The request uses the DNS to find the IP address of a remote computer, knocks on the door of port 8000, and then executes and returns index.php')
            ->addAnswer('The request leaves via port 8000 on my computer, but then routes back to my computer and executes index.php')
            ->addAnswer('The request routes back to port 8000 on my local computer and `index.php` is executed and returned', true);
    }

    public function getExplanation()
    {
        return <<<EOF
`localhost` is a special string that resolves to the IP address of the computer you're
using right now. This means that the request leaves our computer, then comes right
back. The `:8000` means that it knocks on the door of port `8000`. Finally, in most
setups, since there is no filename in the URL, `index.php` is executed and returned.
EOF;
    }
}
