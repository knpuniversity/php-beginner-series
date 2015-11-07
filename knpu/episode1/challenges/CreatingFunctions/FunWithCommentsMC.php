<?php

namespace Challenges\CreatingFunctions;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class FunWithCommentsMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Put on your thinking cap and look carefully: what does this print?

```php
<?php
/*
 * A Functions!
 */
function cat()
{
    \$dog = dog();
    // \$dog = strtoupper(\$dog);

    return \$dog;
}

/* Another function */
function dog()
{
    return 'Molly';
}

\$var = cat();
echo \$var; echo ' the dog'; // echo '!';
```
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('Trick question! This will have an error!')
            ->addAnswer('MOLLY the dog!')
            ->addAnswer('Molly the dog', true)
            ->addAnswer('MOLLY the dog');
    }

    public function getExplanation()
    {
        return <<<EOF
Phew! First, we call `cat()`, which calls `dog()` and sets `\$dog` to `Molly`. But
the next `strtoupper()` line is commented out with `//` so it *never* runs. This
means that `cat()` returns `Molly`, which is set to `\$var`. Finally, we print this
with `echo`, and it *is* legal to have multiple PHP statements on a single line,
as long as each ends with `;`. But, the last `echo '!';` is commented out, and never
runs. That gives us `Molly the dog`.

Oh, and `/*` is another way to start a comment. The difference is that - instead of
commenting out the rest of the line, it comments out everything until it sees a
closing `*/`.
EOF;
    }
}
