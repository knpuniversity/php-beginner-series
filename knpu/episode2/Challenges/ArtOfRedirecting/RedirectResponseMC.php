<?php

namespace Challenges\ArtOfRedirecting;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class RedirectResponseMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Which of the following is the response that's sent back when we redirect a user from a page?
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('ANSWER')
            ->addAnswer('ANSWER')
            ->addAnswer('ANSWER');
            ->addAnswer('ANSWER');
    }

    public function getExplanation()
    {
        return <<<EOF
EXPLANATION GOES HERE!
EOF;
    }
}
