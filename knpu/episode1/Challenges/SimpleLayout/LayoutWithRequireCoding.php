<?php

namespace Challenges\SimpleLayout;

use KnpU\ActivityRunner\Activity\CodingChallenge\CodingContext;
use KnpU\ActivityRunner\Activity\CodingChallenge\CorrectAnswer;
use KnpU\ActivityRunner\Activity\CodingChallengeInterface;
use KnpU\ActivityRunner\Activity\CodingChallenge\CodingExecutionResult;
use KnpU\ActivityRunner\Activity\Exception\GradingException;
use KnpU\ActivityRunner\Activity\CodingChallenge\FileBuilder;

class LayoutWithRequireCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The site has just one page - `index.php` - and even still, people *love* it
(trust us)! Now we've created a second page - `aboutUs.php`, but boy is it ugly!
We need to re-use the layout that's in `index.php` in order to make it prettier.

To do that, move all the header HTML into `header.php`, move all the footer HTML
into `footer.php`, and then `require` each of these files in `index.php` and `aboutUs.php`
so that we get the same, "nice" layout.
EOF;
    }

    public function getFileBuilder()
    {
        $fileBuilder = new FileBuilder();

        $fileBuilder->addFileContents('aboutUs.php', <<<EOF
<!-- require the header here -->

<h1>About Us</h1>

<p>
We're just a couple of <mark>crazy</mark> cats with a dog-gone good idea!
</p>

<address>
  <strong>AirpupNMeow</strong><br>
  555 Main Street<br>
  San Francisco, CA 94107<br>
  <abbr title="Phone">P:</abbr> (123) 456-7890
</address>

<!-- require the footer here -->
EOF
        );
        $fileBuilder->setEntryPointFilename('aboutUs.php');

        $fileBuilder->addFileContents('index.php', <<<EOF
<?php
    \$airpupTagLine = 'We luv puppies!';
?>

<!-- HEADER CODE STARTS HERE -->
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
<!-- HEADER CODE ENDS HERE -->

    <h1>Welcome to AirPupNMeow.com!</h1>
    <h3><?php echo \$airpupTagLine; ?></h3>

<!-- FOOTER CODE STARTS HERE -->
	<footer>
        &copy; 2015 AirPupNMeow.com
	</footer>
	</div>
</body>
</html>
<!-- FOOTER CODE STARTS HERE -->
EOF
        );

        $fileBuilder->addFileContents('layout/header.php', <<<EOF
<!-- Move the HEADER code into here -->
EOF
        );

        $fileBuilder->addFileContents('layout/footer.php', <<<EOF
<!-- Move the FOOTER code into here -->
EOF
        );

        return $fileBuilder;
    }

    public function getExecutionMode()
    {
        return self::EXECUTION_MODE_PHP_NORMAL;
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $result->assertInputContains('layout/header.php', '<html>');
        $result->assertInputContains('layout/footer.php', '</html>');
        $result->assertInputContains(
            'index.php',
            '$airpupTagLine =',
            'Keep the `$airpupTagLine = ...` code inside `index.php`: that\'s code that is used for just *this* page, and shouldn\'t be in the header'
        );
        $result->assertInputContains('index.php', 'require', 'Don\'t forget to require the `header.php` and `footer.php` files in `index.php` so that it still has the nice layout');

        $result->assertOutputContains('<html>', 'Don\'t forget to require the `header.php` file in `aboutUs.php` so that it has the nice layout');
        $result->assertOutputContains('</html>', 'Don\'t forget to require the `footer.php` file in `aboutUs.php` so that it has the nice layout');
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer->setFileContents('aboutUs.php', <<<EOF
<?php require 'layout/header.php'; ?>

<h1>About Us</h1>

<p>
We're just a couple of <mark>crazy</mark> cats with a dog-gone good idea!
</p>

<address>
  <strong>AirpupNMeow</strong><br>
  555 Main Street<br>
  San Francisco, CA 94107<br>
  <abbr title="Phone">P:</abbr> (123) 456-7890
</address>

<?php require 'layout/footer.php'; ?>
EOF
        );

        $correctAnswer->setFileContents('index.php', <<<EOF
<?php
    require 'layout/header.php';

    \$airpupTagLine = 'We luv puppies!';
?>

<h1>Welcome to AirPupNMeow.com!</h1>
<h3><?php echo \$airpupTagLine; ?></h3>

<?php require 'layout/footer.php'; ?>
EOF
        );

        $correctAnswer->setFileContents('layout/header.php', <<<EOF
<!-- HEADER CODE STARTS HERE -->
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
</head>
<body>
    <div class="container">
<!-- HEADER CODE ENDS HERE -->
EOF
        );

        $correctAnswer->setFileContents('layout/footer.php', <<<EOF
<!-- FOOTER CODE STARTS HERE -->
	<footer>
        &copy; 2015 AirPupNMeow.com
	</footer>
	</div>
</body>
</html>
<!-- FOOTER CODE STARTS HERE -->
EOF
        );
    }
}
