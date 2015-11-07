<?php

namespace Challenges\SystemSetup;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class DnsFairyMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
What's the job of the DNS (fairy)?
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('To guide the request to the correct server')
            ->addAnswer('To turn a domain name into an IP address', true)
            ->addAnswer('To listen on a port for a request')
            ->addAnswer('To pass the request to the web server');
    }

    public function getExplanation()
    {
        return <<<EOF
The DNS converts a domain name to an IP address. With the IP address, the request
can find the right server to go to.
EOF;
    }
}
