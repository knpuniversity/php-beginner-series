<?php

namespace Challenges\RequireInclude;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class NoClosingPhpTagMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Look at the following piece of code:

```php
<?php
    \$site = 'AirPup';
?>

<?php echo \$site;

// end of the file
```

Which is true?
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('This code has no issues. Well done!', true)
            ->addAnswer('This code will have an error: it\'s missing the closing `?>` at the bottom')
            ->addAnswer('This code has no error, but it *should* have a `?>` at the bottom')
            ->addAnswer('This code will have an error, because you can\'t put a comment at the bottom of the file');
    }

    public function getExplanation()
    {
        return <<<EOF
Whenever you open PHP with `<?php`, you need to close it later in that file with `?>`...
**unless** the `?>` would be at the end of the file. In other words, if you forget
to write `?>` at the bottom of the file, PHP basically writes this for you - so it's
not needed. In fact, for reasons you'll learn later, it's best *not* to add the `?>`
at the bottom of the file when you don't need to.
EOF;
    }
}
