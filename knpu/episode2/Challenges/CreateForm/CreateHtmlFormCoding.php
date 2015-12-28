<?php

namespace Challenges\CreateForm;

use KnpU\Gladiator\CodingChallenge\CodingContext;
use KnpU\Gladiator\CodingChallenge\CorrectAnswer;
use KnpU\Gladiator\CodingChallenge\Exception\GradingException;
use KnpU\Gladiator\CodingChallengeInterface;
use KnpU\Gladiator\CodingChallenge\CodingExecutionResult;
use KnpU\Gladiator\CodingChallenge\ChallengeBuilder;
use KnpU\Gladiator\Grading\HtmlOutputGradingTool;
use KnpU\Gladiator\Worker\WorkerLoaderInterface;

class CreateHtmlFormCoding implements CodingChallengeInterface
{
    /**
     * @return string
     */
    public function getQuestion()
    {
        return <<<EOF
The pet toy business is *so* popular that we're becoming the Etsy of dog toys:
allowing other people to post their own vintage, organic, vegan toys on our
site to sell. Create an HTML form that submits a POST request to `/new_toy.php`
and give it 2 fields: an input text field called `name` and a `textarea` field
called `description`:

EOF;
    }

    public function getChallengeBuilder()
    {
        $builder = new ChallengeBuilder();

        $builder
            ->addFileContents('new_toy.php', <<<EOF
EOF
            )
            ->setEntryPointFilename('new_toy.php')
        ;

        return $builder;
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
        $htmlGrader = new HtmlOutputGradingTool($result);

        $crawler = $htmlGrader->getCrawler()->filter('form');
        if (count($crawler) == 0) {
            throw new GradingException('Did you create a `form` tag yet?');
        }

        if ($crawler->attr('action') != '/new_toy.php') {
            throw new GradingException('Make sure your form submits to `/new_toy.php`');
        }

        if (strtolower($crawler->attr('method')) != 'post') {
            throw new GradingException('Make sure your form has a `method` attribute on your `form` set to `POST`');
        }

        $form = $crawler->form();
        if (!$form->has('name')) {
            throw new GradingException('I don\'t see any field with `name="name"`');
        }
        if (!$form->has('description')) {
            throw new GradingException('I don\'t see any field with `name="description"`');
        }
    }

    public function configureCorrectAnswer(CorrectAnswer $correctAnswer)
    {
        $correctAnswer
            ->setFileContents('new_toy.php', <<<EOF
<form action="/new_toy.php" method="POST">
    <input type="text" name="name" />
    <textarea name="description"></textarea>

    <button type="submit">Add toy</button>
</form>
EOF
            )
        ;
    }
}
