The wonderful if Statements
===========================

Let's start to make our code smarter! Modify your ``pets.json`` file and
remove the ``age`` key from just one of the pets. When we refresh, it doesn't
fail nicely, it gives us a big ugly warning:

    Undefined index: age in /path/to/index.php on line 95

Let's dump the ``$cutePet`` variable inside the loop to see what's going on.
Each pet is an associative array, but as you probably suspected, Pico de
Gato is missing her ``age`` key. When you reference a key on an
array that doesn't exist, PHP will complain. Instead, let's code defensively.
In other words, if we know that it's possible that the ``age`` key might
be missing, we should check for it and only print the age if it's there.

To do this, we'll finally meet the wonderful and super-common ``if`` statement.
Like :ref:`foreach <php-foreach>`, it's a "language construct", and is one of those things
that uses curly braces to surround a block of code::

    if (true) {
        echo $cutePet['age'];
    }

Where ``foreach`` accepts an array and executes the code between its curly
braces one time for each item, ``if`` accepts a Boolean value - in other words
``true`` or ``false``. If what you pass it is true, it executes the code
between its curly braces.

In this case, I'm literally passing it the boolean ``true``. The ``echo`` will
always be called, since true will be true now, tomorrow and forever. What we
really need is a function that can tell us if the ``age`` key exists on the
``$cutePet`` array.

That function is called :phpfunction:`array_key_exists`. Let's look at its
docs to make sure we know how it works. The first argument is the key, the
second is the array, and it returns a Boolean. Perfect!

.. code-block:: php

    if (array_key_exists('age', $cutePet)) {
        echo $cutePet['age'];
    }

Great! 3 pets have an age and one doesn't. This all happens with no warnings.
``array_key_exists`` returns true for 3 pets and false for our friend Pico de Gato.

If-else
-------

But instead of rendering nothing if there is no age, let's print "Unknown".
We can do this by adding an optional ``else`` part to our ``if``::

    if (array_key_exists('age', $cutePet)) {
        echo $cutePet['age'];
    } else {
        echo 'Unknown';
    }

When we refresh, it works! You'll use ``if`` statements all the time, both
with and without the optional ``else`` part.

Combining If Conditions
-----------------------

Let's complicate things again by removing the age of another pet. But this
time, don't remove the whole key, just set the age to an empty string. When
we refresh, we're still free of errors. But the age for Chew Barka is missing.
Since it's blank, I would rather it say "Unknown".

If we dump the ``$pets`` array and refresh, we can see that this makes sense.
Chew Barka has an ``age`` key, so ``array_key_exists`` returns true, and
the age - which is a blank string - is printed out. What we really want
is for the code in the ``if`` statement to only run if the ``age`` key
exists *and* isn't blank.

Let's do this first by adding a new ``if`` statement inside our existing one.
We'll check the age and only print it if it's *not* empty::

    if (array_key_exists('age', $cutePet)) {
        if ($pet['age'] != '') {
            echo $cutePet['age'];
        }
    } else {
        echo 'Unknown';
    }

The ``!=`` is what you use when you want to compare 2 values to see if they
are not the same. If the age is is not empty, then this expression returns
true and the echo runs.

Make sure also to add an ``else`` statement so that "Unknown" is printed
if the ``age`` *is* empty::

    if (array_key_exists('age', $cutePet)) {
        if ($pet['age'] != '') {
            echo $cutePet['age'];
        } else {
            echo 'Unknown';
        }
    } else {
        echo 'Unknown';
    }

This is all getting a little messy, but let's try it! When we refresh, 2
pets have ages, 2 say "Unknown", and we have exactly zero warnings. Nice!

The mess is that we have a lot of code for such a small problem. We also have
the word "Unknown" written in 2 places. Code duplication is always a bummer
because when you need to change this word later, you may forget about the
duplication and only change it in one spot. Code duplication creates bugs!

Let's simplify. Really, we want to print the age if the ``age`` key exists
*and* is not an empty string. We can just put both of these conditions in
one ``if`` statement::

    if (array_key_exists('age', $cutePet) && $pet['age'] != '') {
        echo $cutePet['age'];
    } else {
        echo 'Unknown';
    }

The secret is the double "and" sign, or ampersand if we are being formal.
An ``if`` statement can have as many parts, or expressions in it as you want.
This ``if`` statement has two expressions, the ``array_key_exists`` part
and the part that checks to see if the age is empty. Each returns
true or false on its own. By using ``&&`` between each expression, it means
that every part must be true in order for the ``if`` statement to run. In
other words, this is perfect.

Refreshing this time shows that things work just like before. But now our code
is shorter, easier to read, and has no pesky duplication.

If-else-if
----------

By now, you probably know that as soon as we get things working, I'll challenge
us by adding something harder! Imagine that sometimes the dog owner knows
the age of her dog, but purposefully wants to hide it. Let's change the age
of Spark Pug to "hidden". When we see this, let's print a friendly message
to contact the owner for the age.

We already have all the tools to make this happen, using another nested ``if``
statement::

    if (array_key_exists('age', $cutePet) && $pet['age'] != '') {
        if ($pet['age'] == 'hidden') {
            echo 'Hi! Email the owner for the age details please!';
        } else {
            echo $cutePet['age'];
        }
    } else {
        echo 'Unknown';
    }

It works perfectly!

But let's see if we can flatten our code to use just one level of an ``if``
statement. There's nothing wrong with nested ``if`` statements, but sometimes
they're harder to understand. We really have just 3 possible scenarios:

1. The ``age`` key does not exist or is blank. We print "Unknown".

2. The ``age`` key is equal to the string "hidden". For this, print our
   nice message about contacting the owner.

3. And if those other conditions don't apply, print the age!

When we had only one scenario, we just used an ``if``. When we had two scenarios,
we used an ``if-else``. For 3 or more, we'll go crazy with an ``if-elseif``::

    if (condition #1) {
        echo 'Unknown';
    } elseif (condition #2) {
        echo 'Hi! Email the owner for the age details please!';
    } else {
        echo $cutePet['age'];
    }

This is really how it looks, except for the "condition #1" and "condition #2"
parts where we'll put real code that returns true or false. Like with the
simple ``if``, the ``else`` is optional, and you can actually have as many
``elseif`` parts as you want depending on how many different scenarios you
have.

.. tip::

    If you have many different scenarios, try using the somewhat rare, but
    handy `switch case`_ statement instead of a giant ``if-elseif`` block.

Combining Conditions with "or" and the not (!) Operator
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Let's make our code follow this format. First, we need to check if the age
key does not exist or if its value is empty. This is kind of the opposite
of what we had before::

    if (!array_key_exists('age', $cutePet) || $pet['age'] == '') {
        echo 'Unknown';
    } elseif (condition #2) {
        echo 'Hi! Email the owner for the age details please!';
    } else {
        echo $cutePet['age'];
    }

Ok, let's break this down. First, by putting the exclamation point in front
of ``array_key_exists``, it negates its value. If the function returns ``true``,
this changes it to ``false`` and vice-versa. We want the first part of our
``if`` to execute if the ``age`` key does *not* exist. The exclamation
gives us that exactly.

Next, the ``&&`` becomes two "pipe" or line symbols (``||``). These mean
"or" instead of and: we want our code to run if the ``age`` key does not
exist *or* if its value is blank. Between ``&&`` and ``||``, you can create
some pretty complex logic in your ``if`` statements.

.. tip::

    You can also use extra parenthesis to group conditions together, like
    you do in math. We'll see this later.

Finally, we used 2 equal signs (``==``) to see if the age value is equal
to an empty string. This is *very* important: do not use a single equal sign when
comparing 2 values. In fact, no matter where you are, repeat after me: "I
solemnly swear to not use a single equal sign to compare values in an if statement". 

The reason is that we use one equal sign to set a value on a variable::

    // sets the age key to an empty string
    $cutePet['age'] = '';

This is especially tricky because if you use only one equal sign the code will run.
But, instead of comparing the two values, it sets the age to an empty string. 
This wouldn't break our code here, but it would in almost all other cases.

So when comparing values, use ``!=`` and ``==``.

.. tip::

    There are a few other symbols for comparing values, like ``<`` and ``>``
    for comparing numbers. There is also a ``===`` symbol, which we'll talk
    about later. For a full list, see `Comparison Operators`_

What is an Operator?
~~~~~~~~~~~~~~~~~~~~

And by the way, these are called "operators". That's a generic word for a
number of different symbols in PHP that operate on a value. We've seen a
bunch so far, including ``=``, which is called an assignment operator since
it assigns a value to a variable. ``&&`` and ``||`` are called logical operators,
they help combine different things to see if all of them put together
are logically true or false. Knowing how to define an operator isn't important,
just know that when you hear the word "operator", we're talking about some
special symbol or group of symbols that do some special job.

Phew! Let's fill in the rest of our ``if-elseif`` statement, which should
be pretty easy now::

    if (!array_key_exists('age', $cutePet) || $pet['age'] == '') {
        echo 'Unknown';
    } elseif ($pet['age'] == 'hidden')
        echo 'Hi! Email the owner for the age details please!';
    } else {
        echo $cutePet['age'];
    }

Try it! Oh man, a terrible error!

.. highlights::

    Parse error: syntax error, unexpected 'else' (T_ELSE) in /path/to/index.php
    on line 101

Let's go to the line number and try to spot the problem. My editor helps me
find it, but let's look ourselves. Always look first to see if you
missed a semicolon - it's the most common mistake. And also look at the lines
above the error. Ah ha! I forgot my opening ``{`` on the ``elseif`` part.
Rookie mistake::

    if (!array_key_exists('age', $cutePet) || $pet['age'] == '') {
        echo 'Unknown';
    } elseif ($pet['age'] == 'hidden') {
        echo 'Hi! Email the owner for the age details please!';
    } else {
        echo $cutePet['age'];
    }

After fixing it, everything looks great.

Ok, you just learned a lot about if statements and using operators to compare
values. I'll teach you some more tricks later, but now let's practice and
get great with if statements.

.. _`switch case`: http://us2.php.net/manual/en/control-structures.switch.php
.. _`Comparison Operators`: http://us2.php.net/manual/en/language.operators.comparison.php
