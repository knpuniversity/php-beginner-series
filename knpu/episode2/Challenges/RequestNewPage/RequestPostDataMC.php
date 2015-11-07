<?php

namespace Challenges\RequestNewPage;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class RequestPostDataMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
When you go to a site, your browser makes a request for that page, and even
sends extra information, like what language you prefer. A request to
`pets_new.php` might look like this:

```
POST /pets_new.php
Host: localhost:8000
Accept-Language: en-US,en;q=0.8

pet_name=Waggy%20Pig&breed=bichon
```

Which of the following most accurately describes this request?
EOF;
    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer('The user just browsed to this page, and the form will be pre-filled with the data on the last line.')
            ->addAnswer('The user surfed to `/pets_new.php` and submitted a form. The data on the bottom is what they filled in for the form fields.')
            ->addAnswer('The user just performed a search for all pets named "Waggy Pig" and breed "bichon"')
            ->addAnswer('The user just submitted a form  with `<form action="/pets_new.php" method="POST">`and the data on the bottom is what they filled in for the form fields.', true)
        ;
    }

    public function getExplanation()
    {
        return <<<EOF
Because this is a `POST` request to `/pets_new.php`, it's definitely a result
of the user submitting a form - on some page - with `method="POST"` and `action="/pets_new.php"`.
The form *might* live at `/pets_new.php`, but that's not important - the form could
live anywhere. The important part is that it submits to `/pets_new.php`.

The data in the bottom are the form fields. So, this form has two fields: one with
`name="pet_name"` - that the user filled in with `Waggy Pig` - and another with `name="breed"`
that was filled in with `bichon`.
EOF;
    }
}
