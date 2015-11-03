<?php

namespace Challenges\ReadingFormData;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class ArrayKeyExistsIssetMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
What's the difference between `array_key_exists()` and `isset()`?
EOF;
    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder
            ->addAnswer('There\'s not much difference: both do basically the same thing.', true)
            ->addAnswer('`array_key_exists` returns false if a key does not exist on an array. But `isset()` returns a warning in this case.')
            ->addAnswer('`array_key_exists` can be used on all arrays, but `isset` can only be used with associative arrays')
        ;
    }

    public function getExplanation()
    {
        return <<<EOF
You can use both `array_key_exists` and `isset` interchangeably to see if a key
exists on an array. `isset` is a little shorter, so I like it.

There *are* a few subtle differences between the two, and `isset` can also be used
to see if a variable has been defined. You'll learn more about that stuff later.
EOF;
    }
}
