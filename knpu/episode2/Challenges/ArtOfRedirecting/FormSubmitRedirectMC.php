<?php

namespace Challenges\ArtOfRedirecting;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

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
        $builder
            ->addAnswer('Redirecting prevents the user from accidentally re-submitting the form', true)
            ->addAnswer('POST requests (which most form submits are) cannot have responses with content, so we need to redirect to another page')
            ->addAnswer('Redirecting prevents the form from being re-populated with the same data')
            ->addAnswer('Some older browsers cannot properly handle a form submit, unless it redirects')
        ;
    }

    public function getExplanation()
    {
        return <<<EOF
Why do we redirect after a successful form submit? The reason isn't that technical:
you don't *have* to redirect the user. But, when you do, if the user refreshes their
page after the redirect, it will just reload that new page. If you *don't* redirect
(e.g. you display a thanks message on the same page that handled your form), the user
can refresh the page, which will re-submit the data: i.e. re-send the POST request
with all the data. This will cause the whole form to be re-processed. You probably
don't want that :).
EOF;
    }
}
