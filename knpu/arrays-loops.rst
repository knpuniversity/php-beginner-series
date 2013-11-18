Arrays and Loops
================

We've seen how we can create variables and set each to a string or a number.
We've also used functions like ``rand`` and ``strtoupper`` to return numbers
and strings. Let's talk about a third type of variable in PHP: an array.
An array represents a group of things, like 5 random numbers or 3 strings.
They're a really important type of data in PHP, and in a few minutes, you'll
know all about them.

To understand arrays, first imagine that there are 3 pets in the system.
For starters, I'll just set their names to 3 variables and print each out
manually:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $pet1 = 'Chew Barka';
        $pet2 = 'Spark Pug';
        $pet3 = 'Pico de Gato';
    ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <h2><?php echo $pet1; ?></h2>
            </div>
            <div class="col-lg-4">
                <h2><?php echo $pet2; ?></h2>
            </div>
            <div class="col-lg-4">
                <h2><?php echo $pet3; ?></h2>
            </div>
        </div>
    </div>

When we refresh, we see the 3 park friendly pets in our styled list. Now obviously, we're
repeating code unnecessarily and writing all the ``div`` and ``h2`` tags is too much work. 
Arrays to the rescue!

Creating an Array
-----------------

To create an array, just say - amazingly - ``array`` and set it to a variable:

.. code-block:: html+php

    <?php
        $pets = array();
    ?>

.. tip::

    In PHP 5.4 and higher, you can also say ``$pets = [];``. The two ways
    mean exactly the same thing.

This looks just like a function, and basically it is. But instead of returning
a string or number, it returns an array, which is like a box that you can
put strings, numbers or other things into. Right now the box is empty.

To put things in the box, just pass them as arguments when creating
the array:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $pet1 = 'Chew Barka';
        $pet2 = 'Spark Pug';
        $pet3 = 'Pico de Gato';

        $pets = array($pet1, $pet2, $pet3);
    ?>

.. note::

    ``array()`` takes an unlimited number of arguments. So put as many things
    into your array as you want!

There are now 3 strings inside our array waiting to see what we'll do with
them. Like any box full of stuff, we can either pull out one specific
item or pull out every item one at a time. In our case, we want to loop through 
each pet and print its name inside our HTML markup.

.. _php-foreach:

Looping over an Array
---------------------

In PHP, we loop over arrays using the all-important :phpfunction:`foreach`
statement. Let's remove the repeated code we have now and create just 1 loop
that will print all 3:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $pet1 = 'Chew Barka';
        $pet2 = 'Spark Pug';
        $pet3 = 'Pico de Gato';

        $pets = array($pet1, $pet2, $pet3);
    ?>

    <div class="container">
        <div class="row">
            <?php
                foreach ($pets as $pet) {
                    echo '<div class="col-lg-4">';
                    echo '<h2>';
                    echo $pet;
                    echo '</h2>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>

Refresh and success! Congratulations on creating and looping over your first
array. This is one of the most common and important skills in PHP.

One unfortunate side effect is that we're now printing out the static HTML
tags like the ``div`` and the ``h2`` via PHP. This is totally fine, but it
looks a bit uglier. There is a way to make this all look a lot prettier,
which we'll talk about in the next episode of this series.

``foreach`` isn't a function, it's what's called a "language construct".
That basically means that it looks and works like a function, but has its own,
special syntax. There aren't many of these language constructs and I'll point
them out along the way.

To loop, we say ``$pets as $pet``. The first variable is the array we're looping
over and the second is a new variable name, which PHP sets to the value of each
item in the array as we loop. Since our array has 3 strings in it, ``foreach``
executes the lines between ``{`` and ``}`` 3 times and ``$pet`` is set to a
different string each time.

If I change ``$pet`` to something else, that's fine, as long as I change it
inside the curly braces as well::

    foreach ($pets as $cutePet) {
        echo '<div class="col-lg-4">';
        echo '<h2>';
        echo $cutePet;
        echo '</h2>';
        echo '</div>';
    }

Also notice that our new code contains the first 2 lines of PHP that *don't*
end in a semicolon. This is pretty common: either you're writing a normal
line that ends in a semi-colon or you're using a language construct that has
an opening ``{`` and a closing ``}``. We'll see another example of that later
with the ``if`` statement.

Accessing Specific Items in an Array
------------------------------------

In addition to looping over each item in an array, you can also just access
one specific item. First, let's see how an array looks under the
surface by using a handy debugging function called :phpfunction:`var_dump`.
``var_dump``, like ``echo``, prints things to the screen. But ``var_dump``
is better for debugging because it prints things out in a really descriptive
way. If you have a variable and want to know everything about it, ``var_dump``
is your new best friend:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $pet1 = 'Chew Barka';
        $pet2 = 'Spark Pug';
        $pet3 = 'Pico de Gato';

        $pets = array($pet1, $pet2, $pet3);
        var_dump($pets);
    ?>

When we refresh, we see the word "array" that tells us what type of value
our variable is. Afterwards, we see our 3 strings next to the number 0, 1
and 2:

.. code-block:: text

    array(3) {
      [0] =>
      string(10) "Chew Barka"
      [1] =>
      string(9) "Spark Pug"
      [2] =>
      string(12) "Pico de Gato"
    }

Array Keys/Indexes
~~~~~~~~~~~~~~~~~~

As we can see, an array does more than just hold things, it also gives each
a unique identifier. Imagine you're going to see a fancy orchestra
performance. When you walk in, there's a coat room. You give your coat to
the attendee who attaches a unique number to it and then gives you a copy
of that number. The coatroom is an array of different coats, but each has
a unique number. When the night is over, you tell the attendee your number
and he finds and returns just your coat.

A PHP array is just as simple and as you can see, the first item is assigned
the number 0, the second is assigned 1, the third item 2, and so on if we had 
more pets. This number is called the array key or index. Later we'll see how 
we can even control these keys instead of letting them be auto-assigned like
it is now.

To access a single item, just look it up by its key using a square bracket
syntax:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $pet1 = 'Chew Barka';
        $pet2 = 'Spark Pug';
        $pet3 = 'Pico de Gato';

        $pets = array($pet1, $pet2, $pet3);

        echo $pets[0];
        echo $pets[2];
    ?>

When we fresh, we see the first and third pets printed. Now we have real
control! But be careful, if you try to use an index that doesn't exist, PHP
gets angry::

    echo $pets[3];

.. highlights::

    Notice: Undefined offset: 3 in /path/to/project/index.php on line 87

We'll talk more about array keys in the next chapter.

Putting other Stuff into an Array
---------------------------------

We've only put strings into our array so far, but we can really put anything there,
like a number:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $pet1 = 'Chew Barka';
        $pet2 = 'Spark Pug';
        $pet3 = 'Pico de Gato';

        $pets = array($pet1, $pet2, $pet3, 14);
    ?>

It's not a particularly exciting pet name, but when we refresh, we see 14
in our pet list.

An array is just a container that can hold anything. Each item in the array
is given a unique key or index, which we can use to reference that item later
if we need to. Heck, we can even put another array inside our array. We'll
try that craziness next!

Arrays have a lot more power, alternate syntaxes and a `load of functions`_
that can operate on them. But right now, let's practice with the activities!

.. _`load of functions`: http://php.net/manual/en/ref.array.php
