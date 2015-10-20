<?php

namespace Challenges\FilesJsonBooleans;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class JsonEncodeMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Pop Quiz: `json_encode` does which of the following?
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('Encodes JSON into a PHP array')
            ->addAnswer('Encodes a PHP array into JSON', true)
            ->addAnswer('Reads a JSON file and sets it into a PHP array');
    }

    public function getExplanation()
    {
        return <<<EOF
The first argument to `json_encode` is a PHP array. It then encodes this and
returns the equivalent JSON string:

```php
<?php echo json_encode('lions', 'tigers', 'bears'); ?>
```

This would print:

```json
[
    "lions",
    "tigers",
    "bears"
]
```
EOF;
    }
}
