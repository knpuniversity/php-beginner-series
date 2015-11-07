<?php

namespace Challenges\SimpleLayout;

use KnpU\Gladiator\MultipleChoice\AnswerBuilder;
use KnpU\Gladiator\MultipleChoiceChallengeInterface;

class RequireAndVariablesMC implements MultipleChoiceChallengeInterface
{
    public function getQuestion()
    {
        return <<<EOF
Suppose your `index.php` file creates a variable and includes a `header.php` file:

```php
<!-- index.php -->
<?php
    \$secretWord = 'engage';

    require 'header.php';
?>
```

Inside of `header.php`, what would happen if you tried to access this `\$secretWord` variable?

```php
<!-- header.php -->
<header>
    <?php echo \$secretWord; ?>
</header>
```
EOF;

    }

    public function configureAnswers(AnswerBuilder $builder)
    {
        $builder->addAnswer('This would print `engage` in the `<header>` tag', true)
            ->addAnswer('This would cause an error: the `$secretWord` variable is defined in `index.php`, not in `header.php`')
            ->addAnswer('There would be no error, but nothing would print inside the `<header>` tag');
    }

    public function getExplanation()
    {
        return <<<EOF
When you `require` or `include` a file, all variables that you currently have access
to  - like `\$secretWord` - are still accessible in the new file. When you use `require`,
it's almost like someone copies the contents of `header.php` and pastes it into
`index.php`.
EOF;
    }
}
