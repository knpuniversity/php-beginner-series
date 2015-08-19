<?php

namespace Challenges\ArtOfRedirecting;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class FormSubmitRedirectMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
After a successful form submit, we always redirect the user to another page. Why?
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
