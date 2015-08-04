<?php

namespace Challenges;

use KnpU\ActivityRunner\Activity\CodingChallenge\MultipleChoice\AnswerBuilder;
use KnpU\ActivityRunner\Activity\MultipleChoiceChallengeInterface;

class OpenPhpMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Everything in a PHP file is just HTML code at first. If you want
to write some dynamic PHP code, you activate PHP mode by always
writing this first:
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('<PHP')
            ->addAnswer('<?php', true)
            ->addAnswer('?>')
            ->addAnswer('echo');
    }

    public function getExplanation()
    {
        return <<<EOF
As soon as you write `<?php` you are in PHP mode. So, `<?php echo 'Hello'; ?>`
gets you into PHP mode and executes `echo 'Hello'`. The `?>` gets
you *out* of PHP mode, and back into normal HTML land.
EOF;
    }
}
