Functions!
==========

We already know what to write when we want to use some PHP code, how to set
a variable, and how to print things. Like most languages, PHP also has functions,
like :phpfunction:`rand`, which gives us a random number:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $cleverWelcomeMessage = 'All the love, none of the crap!';
        $pupCount = rand();
    ?>

A function always starts with its name followed by opening and closing
parentheses. Those are the key and tell PHP that ``rand`` is a function.
Think of a function like a machine: we execute it with the code you see here
and it returns a value. Not all functions work exactly like this, but most
do. So when you see a function, think "this does some work for me and then
returns a value." It might return a number, a string like ``'Hello World'``,
or something more complicated.

The :phpfunction:`rand` function returns a random number. We assign that number
to the ``$pupCount`` variable and then print it just like before with the
``echo`` statement.

When we refresh, we see our number is now dynamic: each time we refresh, the
``rand`` function gives us another number!

.. tip::

    Generating random numbers is actually kind of tough for computers. Another
    function, :phpfunction`mt_rand`, generates "better" random numbers.

PHP comes with a lot of built-in functions like ``rand`` that you can use immediately.
On php.net, you can lookup your function and learn all about it.

.. tip::

    At the time of this recording, php.net was getting a facelift! If you
    see an older, uglier site, you may see a link at the top of the page
    to preview the newer site.

Functions with Arguments
------------------------

Sometimes we can control the behavior of a function by passing it an argument:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $cleverWelcomeMessage = 'All the love, none of the crap!';
        $pupCount = rand(50);
    ?>

An argument appears between the parentheses of the function and tells the
``rand`` function to give us a number that's 50 or larger. For ``rand``,
this argument is optional: the function will work without it and has a default
value of ``0``. I know this by reading its documentation.

.. tip::

    PHP often uses the word "parameter" in place of argument in its documentation
    and error messages. These two words mean the same thing.

In fact, we can see that :phpfunction:`rand` has *2* arguments: the minimum
number *and* a maximum. To pass a second argument, just add a comma after
the first:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $cleverWelcomeMessage = 'All the love, none of the crap!';
        $pupCount = rand(50, 100);
    ?>

When we refresh, our pup number is random, but between 50 and 100. Functions
are machines that do work and return a value. Arguments are input that let
us control the function. We pass arguments to the function as a comma-separated
list inside its parentheses.

.. tip::

    Functions don't always return a value. Some functions just *do* something
    but return nothing. An example is ``var_dump``, which prints to the screen
    similar to ``echo``. We'll see this in a moment.

Capitalizing the first Letter of each Word
------------------------------------------

Every function has a different number of total arguments that mean different
things. Let's look up a cool function called :phpfunction:`ucwords`. This
function has only one argument, but it's required:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $cleverWelcomeMessage = ucwords('All the love, none of the crap!');
        $pupCount = rand(50, 100);
    ?>

When we refresh the browser, every word in the string is upper-cased!

    All The Love, None Of The Crap!

Since the one argument is required, if we leave it off, PHP will give us
a "friendly" reminder:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $cleverWelcomeMessage = ucwords();
        $pupCount = rand(50, 100);
    ?>

.. highlights::

    PHP Warning:  ucwords() expects exactly 1 parameter, 0 given in
    /path/to/project/index.php on line 69

The point is that PHP has *a lot* of functions, and each has different arguments
that mean different things. Some arguments are required, like the first and
only argument of ``ucwords`` and some are optional, like both arguments to
``rand``.

When you need to do something like generate a random number, the best thing
to do is google your question, find the function you need, then research
it on php.net. Every page has comments below it and a spot where you can
learn about similar functions.

Lowercasing all letters / Using Functions in Different Places
-------------------------------------------------------------

Let's look at one of the related functions :phpfunction:`strtolower`. Like the
name suggests, when we give this function its one required argument, it will
make every character lowercase and return it. Let's replace ``ucwords`` with this.
But instead of using it to set the ``$cleverWelcomeMessage`` variable to a
lowercase string, we can use it to lowercase the string message just before
``echo`` prints it:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <div class="jumbotron">
        <div class="container">
            <?php
                $cleverWelcomeMessage = 'All the love, none of the crap!';
                $pupCount = rand(50, 100);
            ?>

            <h1><?php echo strtolower($cleverWelcomeMessage); ?></h1>
            <!-- ... -->
        </div>
    </div>

Just like your new pup, a function can really go anywhere. And variables can be used as arguments.
Remember, ``$cleverWelcomeMessage`` represents our string message, so this
is the same as passing the string directly (e.g. ``strtolower('All the love, none of the crap!')``).

Let's get fancy and use another function - :phpfunction:`strrev` - to print
the string in reverse:

.. code-block:: html+php

    <h1><?php echo strrev(strtolower($cleverWelcomeMessage)); ?></h1>

When we fresh, our string is all lowercase AND reversed.

.. code-block:: html

    <h1>!parc eht fo enon ,evol eht lla</h1>

You can use functions inside of functions like this as much as you want. The
trick is to keep track of your parenthesis and always remember to have a
closing parenthesis for every opening one.

But what order do things take place? Is the string lowercased and then reversed
or reversed first and then lowercased? If we replace ``strrev`` with ``strtoupper``,
the opposite of ``strtolower``, then it becomes obvious:

.. code-block:: html+php

    <h1><?php echo strtoupper(strtolower($cleverWelcomeMessage)); ?></h1>

When we refresh, the string displays completely in upper case:

.. code-block:: html

    <h1>ALL THE LOVE, NONE OF THE CRAP!</h1>

This proves that the string is lowercased first and *then* uppercased. Functions
work from the inside out. Initially ``cleverWelcomeMessage`` is passed as the
first argument to ``strtolower` and a lowercase string is returned. This
lowercase string is then passed as the first argument to ``strtoupper``, which
returns an upper case string. Which is finally printed with ``echo``.
Phew!

This is all really cool, but if you do feel overwhelmed, you could always
write this using multiple lines:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <div class="jumbotron">
        <div class="container">
            <?php
                $cleverWelcomeMessage = 'All the love, none of the crap!';
                $lowerMessage = strtolower($cleverWelcomeMessage);
                $upperMessage = strtoupper($lowerMessage);
                $pupCount = rand(50, 100);
            ?>

            <h1><?php echo strtolower($upperMessage); ?></h1>
            <!-- ... -->
        </div>
    </div>

The most important thing to remember is that PHP has a lot of functions, which
are always written with a set or parenthesis after their name. Some have one
or more arguments that allow you to control the function and the documentation
explains these. Functions typically do some work and return a value, which
you can assign to variables or print using echo. Got it? Ok, onto practicing with
the activities!
