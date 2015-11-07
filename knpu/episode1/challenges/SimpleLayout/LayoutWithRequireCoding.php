<?php

namespace Challenges\SimpleLayout;

use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Grading\PhpGradingTool;
use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class LayoutWithRequireCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The site has just one page - `index.php` - and people *love* it (trust us)! 
Now we've created a second page - `aboutUs.php`, but boy is it ugly! Woof.
We need to re-use the layout that's in `index.php` to make it prettier.

To do that, move all the header HTML into `header.php`, move all the footer HTML
into `footer.php`, and then `require` each of these files in `index.php` and `aboutUs.php`
to get the same, "nice" layout in both of our pages.
EOF;
    }

    public function getChallengeBuilder()
    {
        $fileBuilder = new ChallengeBuilder();

        $fileBuilder->addFileContents('aboutUs.php', <<<EOF
<!-- require the header here -->

<h1>About Us</h1>

<p>
We're just a couple of <mark>crazy</mark> cats with a dog-gone good idea!
</p>

<address>
  <strong>AirPupNMeow</strong><br>
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

    public function getWorkerConfig(WorkerLoaderInterface $loader)
    {
        return $loader->load(__DIR__.'/../php_worker.yml');
    }

    public function setupContext(CodingContext $context)
    {
    }

    public function grade(CodingExecutionResult $result)
    {
        $phpGrader = new PhpGradingTool($result);
        $htmlGrader = new HtmlOutputGradingTool($result);

        $phpGrader->assertInputContains('layout/header.php', '<html>');
        $phpGrader->assertInputContains('layout/footer.php', '</html>');
        $phpGrader->assertInputContains(
            'index.php',
            '$airpupTagLine =',
            'Keep the `$airpupTagLine = ...` code inside `index.php`: that\'s code that is used for just *this* page, and shouldn\'t be in the header'
        );
        $phpGrader->assertInputContains('index.php', 'require', 'Don\'t forget to require the `header.php` and `footer.php` files in `index.php` so that it still has the nice layout');

        $htmlGrader->assertOutputContains('<html>', 'Don\'t forget to require the `header.php` file in `aboutUs.php` so that it has the nice layout');
        $htmlGrader->assertOutputContains('</html>', 'Don\'t forget to require the `footer.php` file in `aboutUs.php` so that it has the nice layout');
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
  <strong>AirPupNMeow</strong><br>
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
