<?php

namespace Challenges\Arrays2;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class GuessAutoKeyMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
The dog-walking service is a hit! So, we've added `Bear` to the
list:

```php
<?php
\$walker1 = 'Kitty';
\$walker2 = 'Tiger';
\$walker3 = 'Jay';

\$dogWalkers = array(\$walker1, \$walker2, \$walker3);
\$dogWalkers[] = 'Bear';
?>
```

What array key will PHP automatically assign to `Bear`?
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer(0)
            ->addAnswer(3, true)
            ->addAnswer(4)
            ->addAnswer('Bear');
    }

    public function getExplanation()
    {
        return <<<EOF
The keys are automatically assigned, starting with *zero*, and when you add a new
item to the array later, it uses the first available number. Since `\$walker3`
was assigned the `2` index, `Bear` gets the next available number: `3`.
EOF;
    }
}
