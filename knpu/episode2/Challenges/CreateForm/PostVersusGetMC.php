<?php

namespace Challenges\CreateForm;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class PostVersusGetMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
When you surf to a page, the user makes a GET request for that URL. When you
submit a form, the user makes a POST request to that URL. Which of the following
is NOT true about GET and POST requests:
EOF;
    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer('POST is used when the user needs to send data. GET is used when a user just wants to fetch a page')
            ->addAnswer('A GET request cannot send any data (i.e. filled-in form fields)', true)
            ->addAnswer('After making both GET and POST requests, the server sends back a response (often the next HTML page to display)')
            ->addAnswer('There\'s no *real* difference between GET and POST requests: both can send data, both cause a response to be returned, but *typically* POST is used to send data.')
        ;
    }

    public function getExplanation()
    {
        return <<<EOF
Even though `POST` requests are typically used to send data, data can be sent via
both `POST` and `GET` requests (with, for example, a `<form method="GET">` form).
So really, there's nothing you can do with a GET request that you can't do with a
POST request and vice-versa. But don't be confused: in practice, POST requests are
used for almost all form submits and GET requests are used everywhere else.
EOF;
    }
}
