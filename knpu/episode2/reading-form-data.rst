Reading POST'ed (Form) Data
===========================

That's done with a super-magic variable called ``$_POST``.

Try it! Let's use my favorite debugging tool ``var_dump`` on this variable::

    <?php var_dump($_POST); ?>

Fill out the form again and submit. It prints out an `associative array`_.
Each key is from the ``name`` attribute of the field and its value is what
we typed in!

Where does $_POST Come From?
----------------------------

Wait, not so fast! Where did this variable come from? We already learned
that if we try to reference a variable name that doesn't exist, PHP gets
really angry and tells us about it::

    <?php var_dump($_POST); ?>
    <?php var_dump($fakeVariable); ?>

Like when we try this, we *do* get a big warning.

Here's the secret: ``$_POST`` is one of just a few variables called "superglobals".
That's nothing more than a heroic way of saying that ``$_POST`` is always
magically available and equal to any submitted form data.

The other superglobals include ``$_GET``, ``$_SERVER`` and a few others.
We'll talk about them later, but they all have one thing in common, besides
their love of capital letters. Each super-global gives you information about
the HTTP request our browser sent.

Getting the Form Data
---------------------

Eventually, we're doing going to save this new pet somewhere, like a database.
We'll get there, but for now, let's set each value to a variable and dump
them to prove it's working. I'll do this right at the top of the page, because
that's a nice place to put your PHP logic:

.. code-block:: html+php

    <?php
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $weight = $_POST['weight'];
    $bio = $_POST['bio'];

    var_dump($name, $breed, $weight, $bio);die;
    ?>

    <?php require 'layout/header.php'; ?>

This time, refresh your browser. This actually re-submits our form with the
same data we entered a second ago. And there it is!

I took advantage of a cool thing about the ``var_dump`` function: it accepts
an unlimited number of arguments. Most functions accept 0, 1, 2 or more arguments.
That's normal. But a few brave guys accept an unlimited number. ``var_dump``
is one of those brave functions, and it's documentation shows us that.

$_POST on GET Requests
----------------------

Click the top nav link to go to the homepage, and then click "Post" to come
back to this form. Oh no, we're blowing up!  When we clicked the link, our
browser sent a simple GET request to the server. We didn't submit a form
to get here, so ``$_POST`` is an *empty* array. This means our keys don't
exist, and PHP is giving us a lot of ugly warnings about it!

Coding Defensively
~~~~~~~~~~~~~~~~~~

Let's fix those warnings first. Any time you reference a key on an array,
you gotta ask yourself: Is it possible that this key might ever *not* exist?
It's better to plan for these cases then let your site have big errors later.
Always think about how your code *could* break and code so that it doesn't.

Right now, this means we need to add some ``if`` statements to see if the
array keys exist, starting with the ``name``:

.. code-block:: html+php

    <?php
    if (array_key_exists('name', $_POST)) {
        $name = $_POST['name'];
    } else {
        $name = 'A dog without a name';
    }

We can shorten this slighty by using ``isset``. It's just like ``array_key_exists``,
but shorter and a bit easier to read:

.. code-block:: html+php

    <?php
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
    } else {
        $name = 'A dog without a name';
    }

Repeat this for all of the fields::

    if (isset($_POST['breed'])) {
        $breed = $_POST['breed'];
    } else {
        $breed = '';
    }

    if (isset($_POST['weight'])) {
        $weight = $_POST['weight'];
    } else {
        $weight = '';
    }

    if (isset($_POST['bio'])) {
        $bio = $_POST['bio'];
    } else {
        $bio = '';
    }

    var_dump($name, $breed, $weight, $bio);die;

Refresh! Ok, warnings are all gone. But we still need to be smarter. When
we make a normal GET request, I don't want to bother looking for any form
data, I just want to render the HTML form. I really only want to run all
of this logic when the browser sends a POST request, meaning we *actually*
just submitted the form.

Detecting GET and POST Requests: $_SERVER
-----------------------------------------

So how can we find out if our code is handling a GET request or a POST request?

If you're thinking the answer is in one of those superglobal variables, you
nailed it! This time, it's ``$_SERVER``. Let's dump it out to see what it
looks like::

    var_dump($_SERVER);die;

Woh! It's an associative array, and it has a *ton* of stuff in it, 25 things
in my case. What is this stuff? Well, it's information about the HTTP request
that was just sent. See the ``HTTP_USER_AGENT`` key? That comes from a piece
of information our browser included in the request.

No, you don't need to memorize this, or really remember any of it. Occasionally
you'll need some information, like the user agent. And when you google for
how to get that in PHP, this will be your answer.

See that ``REQUEST_METHOD`` key? Ah ha! That's the HTTP method, which is
GET right now.

Let's wrap all of our form-processing logic in an ``if`` statement that checks
to see if the ``REQUEST_METHOD`` key is equal to ``POST``:

Refresh! Our browser makes a normal GET request. All that form processing
stuff is skipped and we got our normal, beautiful HTML form. And when we
fill out the form and submit, our browser sends a POST request. Now our
code kicks into action and dumps out all that data. We're not *doing* anything
with our form data yet, but our workflow is looking good!

.. _`associative array`: http://knpuniversity.com/screencast/php-ep1/arrays2
