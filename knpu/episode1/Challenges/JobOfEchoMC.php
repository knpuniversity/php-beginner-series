<?php

namespace Challenges;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class JobOfEcho implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
What's the job of the `echo` statement?
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('to print things out', true)
            ->addAnswer('to exit HTML mode and enter PHP mode')
            ->addAnswer('to end the file')
            ->addAnswer('to create a variable');
    }

    public function getExplanation()
    {
        return <<<EOF
`echo` - as in `echo 'this question was no problem`;` - is used to print anything
out. There are a few other ways to print stuff, but `echo` is by far the most important.
You rock `echo`!
EOF;
    }
}
