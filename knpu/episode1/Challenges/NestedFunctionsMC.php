<?php

namespace Challenges;

use KnpU\ActivityRunner\Activity\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class NestedFunctionsMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Things have gotten out of hand with all these reversed words. See if you
can figure out what this prints:

```php
<?php echo str_replace('ri', 'aa', strrev(strtolower('SQUIRREL!'))); ?>
```
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('!lerriuqs')
            ->addAnswer('!lerraaiuqs')
            ->addAnswer('!leraauqs', true)
            ->addAnswer('lerriauqs');
    }

    public function getExplanation()
    {
        return <<<EOF
Think about the order that things happen:

#. `SQUIRREL!` is passed to `strtolower` and becomes `squirrel!`.
#. `squirrel!` is passed to `strrev` and becomes `!lerriuqs`.
#. Finally, the `ri` in `!lerriuqs` is replaced with `aa`, giving us `!leraauqs`.
EOF;
    }
}
