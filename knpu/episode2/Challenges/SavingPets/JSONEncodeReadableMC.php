<?php

namespace Challenges\SavingPets;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class JSONEncodeReadableMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Which of the following will cause `json_encode` to give us a pretty, more-readable
version of the JSON?
EOF;
    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer('`json_encode($toys, JSON_PRETTY_PRINT);`', true)
            ->addAnswer("`json_encode(\$toys, 'JSON_PRETTY_PRINT');`")
            ->addAnswer('`json_encode($toys, $JSON_PRETTY_PRINT);`')
            ->addAnswer('`json_encode($toys, JSON_PRETTY_PRINT());`')
        ;
    }

    public function getExplanation()
    {
        return <<<EOF
`JSON_PRETTY_PRINT` is called a "constant": it's like a variable, except that
it has no `$` in front of it, cannot be changed, and is available everywhere.
You can create your own constants (see PHP's `define()` function), but some, like
this one, are available everywhere.
EOF;
    }
}
