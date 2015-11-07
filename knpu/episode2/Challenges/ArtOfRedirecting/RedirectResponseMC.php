<?php

namespace Challenges\ArtOfRedirecting;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class RedirectResponseMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Which of the following best shows the raw response that's sent back when we redirect
a user from a page?
EOF;
    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer(<<<EOF
```
HTTP/1.1 302 Found
Location: /thanks.php

<h1>Thanks for adding a new toy!</h1>
```
EOF
            )
            ->addAnswer(<<<EOF
```
HTTP/1.1 302 Found
Location: /thanks.php
```
EOF
            , true)
            ->addAnswer(<<<EOF
```
GET /new_toy.php
Host: localhost:8000

<h1>Add a new toy</h1>
```
EOF
            )
            ->addAnswer(<<<EOF
```
POST /new_toy.php
Location: /new_toy.php
```
EOF
            )
        ;
    }

    public function getExplanation()
    {
        return <<<EOF
The goal of our code is *always* to send a response message back to the user. Normally,
we don't think about this: we're just sending back HTML. But in reality, a response
is made up of multiple parts, including the content and headers.

When we redirect, what we're actually doing is setting a `Location` header on the
response. The status code - something we haven't talked about much - is also always
set to 301 or 302. Answer (A) is technically correct, but misleading: this contains
some HTML content in the response. This will never be shown to your user, because
the user's browser will immediately see the `Location` header and change the URL
in their browser to be this page.
EOF;
    }
}
