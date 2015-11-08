<?php

namespace Challenges\ArraysLoops;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class ArrayKeysMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
```php
\$brands = array('SuperDog', 'Doggie-Os', 'Beef Bites', 'Puppy Gruel', 'Fancy Feast');
```

Puppies love dinner time! Which option below will print "Puppy Gruel"?
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('echo $brands[\'Puppy Gruel\']')
            ->addAnswer('echo $brands(4)')
            ->addAnswer('echo $brands[4]')
            ->addAnswer('echo $brands[3]', true);
    }

    public function getExplanation()
    {
        return <<<EOF
The keys are automatically assigned, starting with *zero*. This means that
`SuperDog` is key 0, `Doggie-Os` is key `1` and eventually `Puppy Gruel` is
key `3`.
EOF;
    }
}
