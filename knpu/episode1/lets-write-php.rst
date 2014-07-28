Let's Write some PHP!
=====================

Welcome! We're glad you're here with us to learn how to become an Epic PHP
developer. PHP is a programming language that runs a `large percentage`_ of
the web including sites as big as Facebook. But since PHP has been around
for awhile, there is a lot of bad, outdated and boring information about
PHP on the web.

But not here! In this course, we'll learn PHP from scratch by building a real
website. This means you'll learn the practices used by real *employed* developers 
to build really cool things, and not just a bunch of theory. We'll teach you something
in each chapter and then you'll test and practice your new skills by coding
right in your browser. Learn and then practice, that's the key! Before long,
you'll be creating more and more complex things and be the coolest guy or
gal that any of your friends know - probably :) 

The Project
-----------

We're going to build a site that we're calling `AirPupnMeow.com`. Imagine a
site like Airbnb.com, except where people rent cute pets instead of apartments.
If you're looking for companionship without all that responsibility of walking
your dog every morning and bringing a bag to pick up his... uh gifts,
then this site would be for you! Ok, the idea might be kinda silly, but that
hasn't stopped startups in the past! So let's go!

What you see here is just an HTML page that I've loaded in my browser

    http://localhost:8000/index.php

This is a template based on `Twitter Bootstrap`_ and it's just a bunch of
hardcoded text and links that don't go anywhere yet. But it's already a cute
start to our rent-a-pet site. 

For now, don't worry about the ``localhost`` part I have in the URL or that
this file ends in ``.php``. Just know that when I load this page, the ``index.php``
file is being opened and all the HTML is rendered by my browser.

I'm going to use my favorite editor called ``PhpStorm`` to open this file
and prove that it's only simple HTML. Later in this course, we'll get your
computer setup to run and modify files just like this.

Right now, this page is totally static. Each time I refresh the page, I get
back the same exact HTML. On real websites, things are dynamic: news stories
update when I refresh and personalized information is pulled from a database.
That's the kind of stuff that PHP does.

Writing your first PHP
----------------------

Let's make this page more interesting!

Before you write PHP code, you'll always start with the same opening tag: ``<?php``.
This is what tells PHP that we're not writing HTML anymore - we actually
want to write some PHP code. Let's print out a cool message by using the
:php:`echo` statement and surrounding our message with single quotes.
Finish off the line with a semicolon and then write the PHP closing tag: ``?>``. 
These last two characters get us out of PHP mode and back into HTML. 
The ``<?php`` and ``?>`` tags are exact opposites and always come in a pair. 
One gets us into PHP mode and the other exits PHP mode:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <div class="jumbotron">
        <div class="container">
            <h1><?php echo 'Look mom, PHP!'; ?></h1>

            <!-- ... -->
        </div>
    </div>

Before we talk about what we did, let's celebrate, because when I refresh
the page, it works! PHP is printing our message in the middle of the page.

The key is the :php:`echo` statement, whose job is to print things
out. The message itself is called a "string" and strings are always surrounded
by single quotes when you write them.

.. tip::

    You can actually use single quotes (``'Foo'``) or double quotes (``"Foo"``).
    They're basically the same. But using single quotes is much more hipster!

Creating and Using Variables
----------------------------

Since printing a static string is boring, let's create a variable! Whenever
we want to write PHP code, remember to open up PHP with ``<?php`` and close
it with ``?>``:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <div class="jumbotron">
        <div class="container">
            <?php

            ?>

            <h1><?php echo 'Look mom, PHP!'; ?></h1>

            <!-- ... -->
        </div>
    </div>

The open and close PHP tags can totally be on separate lines. If we refresh
now, there's no change. Unless we print something from within PHP, nothing
is shown on the page. Even if we add blank lines, they don't appear inside
the HTML source code.

To create a variable, start with a dollar sign (``$``), write a clever name,
then finish it up with an equal sign (``=``) and the value we want to give,
or assign, to the variable. Remember to add a semi-colon at the end of the
line: almost all lines in PHP end in a semi-colon. Did you hear me? Because, 
forgetting this is one of the most common errors you'll make:

.. code-block:: html+php

    <?php
        $cleverWelcomeMessage = 'All the love, none of the crap!';
    ?>

If we refresh, nothing changes yet. that makes sense, because we haven't
printing anything from within PHP! Using the variable is easy, replace our
echo'd string with a ``$`` and the variable name. and just like that, we're
creating and using variables and one step closer to your new best friend:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <div class="jumbotron">
        <div class="container">
            <?php
                $cleverWelcomeMessage = 'All the love, none of the crap!';
            ?>

            <h1><?php echo $cleverWelcomeMessage; ?></h1>

            <!-- ... -->
        </div>
    </div>

Variables as Strings or Numbers
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Of course, variables can also be set to numbers which looks the same but without
the quotes:

.. code-block:: html+php

    <?php
        $cleverWelcomeMessage = 'All the love, none of the crap!';
        $pupCount = 5000
    ?>

Notice that I have 2 PHP lines, or statements, inside one set of opening and
closing PHP tags. That's totally legal: once you open PHP, you can write
as much as you want. Use your new variable to print another message:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <div class="jumbotron">
        <div class="container">
            <?php
                $cleverWelcomeMessage = 'All the love, none of the crap!';
                $pupCount = 5000;
            ?>

            <h1><?php echo $cleverWelcomeMessage; ?></h1>

            <p>With over <?php echo $pupCount ?> pet friends!</p>
            <!-- ... -->
        </div>
    </div>

When we fresh, it's a success!

Making PHP Angry with Syntax Errors!
------------------------------------

Now, let's make a small error to see what happens. I'll just remove the semicolon
from the end of the ``$cleverWelcomeMessage = `` line:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <div class="jumbotron">
        <div class="container">
            <?php
                $cleverWelcomeMessage = 'All the love, none of the crap!'
                $pupCount = 5000;
            ?>

            <h1><?php echo $cleverWelcomeMessage; ?></h1>

            <p>With over <?php echo $pupCount ?> pet friends!</p>
            <!-- ... -->
        </div>
    </div>

.. highlights::

    PHP Parse error: syntax error, unexpected '$pupCount' (T_VARIABLE) in
    /path/to/site/index.php on line 70

You'll see a lot of error messages and the trick is to get good at knowing
what they mean. Be sure to look at the line number and check that line *and*
the lines *above* it. In this case, the error is being reported in the line
with ``$pupCount = ``. But there's nothing wrong with this line - the missing
semicolon is actually the line *above* this. That's really common with PHP
errors, so look for it!

Ok, now it's your turn! Test out your skills with the activities!

.. _`large percentage`: http://w3techs.com/technologies/overview/programming_language/all
.. _`Twitter Bootstrap`: http://getbootstrap.com/
