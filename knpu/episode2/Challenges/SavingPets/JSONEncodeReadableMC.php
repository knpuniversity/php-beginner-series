<?php

namespace Challenges\SavingPets;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class JSONEncodeReadableMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Which of the following will cause json_encode to give us a pretty, more-readable version of the JSON?
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('json_encode($toys, JSON_PRETTY_PRINT);', true)
            ->addAnswer('json_encode($toys, 'JSON_PRETTY_PRINT');')
            ->addAnswer('json_encode($toys, $JSON_PRETTY_PRINT);');
            ->addAnswer('json_encode($toys, JSON_PRETTY_PRINT());');
    }

    public function getExplanation()
    {
        return <<<EOF
EXPLANATION GOES HERE!
EOF;
    }
}
