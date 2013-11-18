Arrays Level 3: We put Arrays in your Arrays!
=============================================

Ok, so we have associative arrays and indexed arrays. And really, they're
the exact same thing: both contain items and each item has a unique key we
can use to access it. We *choose* that key for items in an associated array
and we let PHP choose the keys for us in an indexed array. And because PHP
isn't very creative, it just chooses a number that gets higher each
time we add something. But Regardless of who makes the choice, every key in an
array is either a string or a whole number, which we programmers and mathematicians
call an integer. And that's the end of the story: array keys are *only ever*
strings or integers in all of PHP.

.. code-block:: text

        Key   => Value
    array(
        'foo' => ?
        5     => ?
        'baz' => ?
    );

But each *value* in an array can be *any* type of PHP value. So far we know
three data types in PHP: a string, a number and an array. And as promised,
all three can be put into an array:

.. code-block:: text

        Key   => Value
    array(
        'foo' => 1500,
        5     => 'Hello World!',
        'baz' => array(1, 2, 3, 5, 8, 13),
    );

Multi-dimensional Arrays
------------------------

This means that we can have multi-dimensional arrays: an array with another
one inside of it. Multidimensional arrays are actually pretty common and
pretty easy. Let's tweak our code to make each pet an associate array, just
like Pancake. I'll paste in the details::

    $pet1 = array(
        'name' => 'Chew Barka',
        'breed' => 'Bichon',
        'age'  => '2 years',
        'weight' => 8,
        'bio'   => 'The park, The pool or the Playground - I love to go anywhere! I am really great at... SQUIRREL!',
        'filename' => 'pet1.png'
    );

    $pet2 = array(
        'name' => 'Spark Pug',
        'breed' => 'Pug',
        'age'  => '1.5 years',
        'weight' => 11,
        'bio'   => 'You want to go to the dog park in style? Then I am your pug!',
        'filename' => 'pet2.png'
    );

    $pet3 = array(
        'name' => 'Pico de Gato',
        'breed' => 'Bengal',
        'age'  => '5 years',
        'weight' => 9,
        'bio'   => 'Oh hai, if you do not have a can of salmon I am not interested.',
        'filename' => 'pet3.png'
    );

    $pancake = array(
        'name' => 'Pancake the Bulldog',
        'age'  => '1 year',
        'weight' => 9,
        'bio' => 'Lorem Ipsum',
        'filename' => 'pancake.png'
    );
    $pancake['breed'] = 'Bulldog';

Next, add ``$pancake`` to our ``$pets`` array and remove Kitty Gaga::

    $pets = array($pet1, $pet2, $pet3, $pancake);

Notice that instead of passing a string as each item, we're now passing an
array with lots of information about each pet. Before we go any further,
let's use ``var_dump`` to see how this array looks. I'm also going to use
a new function called :phpfunction:`die`.

    $pets = array($pet1, $pet2, $pet3, $pancake);
    var_dump($pets);
    die;

``die`` kills the execution of the script immediately. It's useful for debugging
because now our variable will print and ``die`` will temporarily prevent
the rest of the page from rendering. That just makes things easier to read.
In my development, ``var_dump`` and ``die`` go together like kittens and
catnip. But as delicious as catnip is to a kitten, never use ``die`` in your real code.

When we refresh, we see the multi-dimensional array. Just like before, the
outermost array is indexed with keys 0, 1 and 2. Each item is now an associative
array with its own keys.

Accessing Data on a Multi-dimensional Array
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

So if we wanted to access the ``breed`` of the second pet in the list, how
can we do that? It's actually wonderfully straightforward. First, access
the second item by using the square bracket syntax, keeping in mind that
array indexes start with 0. Next, add another set of square brackets with
the breed key. Let's ``var_dump`` this to make sure it works::

    $pets = array($pancake, $pet1, $pet2, $pet3);
    $breed2 = $pets[1]['breed'];
    var_dump($breed2);die;

Now that we have an array with details about multiple pets, we're dangerous!
Look back at our ``foreach`` statement. We're still looping over ``$pets``.
But now, ``$cutePet`` is an associative array instead of a string::

    foreach ($pets as $cutePet) {
        echo '<div class="col-lg-4">';
        echo '<h2>';
        echo $cutePet['name'];
        echo '</h2>';
    }

In fact, we already did all this work when we rendered Pancake's details.
Let's just re-use that code and change ``$pancake`` to ``$cutePet``. I'll
tweak a class name as well so that the our pets tile nicely.

.. code-block:: html+php

    <?php foreach ($pets as $cutePet) { ?>
        <div class="col-md-4 pet-list-item">
            <h2><?php echo $cutePet[0]; ?></h2>

            <img src="/images/<?php echo $cutePet[4]; ?>" class="img-rounded">

            <blockquote class="pet-details">
                <?php echo $cutePet[1]; ?>
                <?php echo $cutePet[2]; ?> lbs
            </blockquote>

            <p>
                <?php echo $cutePet[3]; ?>
            </p>
        </div>
    <?php } ?>

.. tip::

    I indented the ``col-md-4`` div 4 spaces inside the ``foreach`` just
    to help me read my code better - it doesn't change anything in PHP or HTML.

Refresh and voilà! To make things cleaner, I also close the PHP tag
after my ``foreach`` statement. This lets me write HTML instead of printing
it from inside PHP, which is hard to read. But it's really the same as before:
we open PHP, start the ``foreach``, close PHP, then later open it
again to add the closing ``}`` for the ``foreach``. If you're not used to
this yet, we'll practice it!

Counting Items in an Array
--------------------------

So we're now doing *a lot* with arrays. Let's add one more thing! As cool
as the ``rand`` function is, I want to print the real value for how many
pets we have in the system. If there were a way to count the number of items
in the ``$pets`` array, we'd be set. Fortunately, PHP gives us a function
that does exactly that called :phpfunction:`count`:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <p>Over <?php echo count($pets) ?> pet friends!</p>

When we refresh, we get an error:

.. highlights::

    Notice: Undefined variable: pets in /path/to/index.php on line 70

The problem is that we're referencing the ``$pets`` variable, but it's not
actually created until after this. PHP reads our file from top to bottom like
a book, so we need to set a variable before using it.

To fix this, let's move every variable all the way up to the top of the
file. Now when we refresh, it works perfectly. If we add a 5th pet later, it will
update automatically.

Let's go to php.net and look up the docs for the :phpfunction:`count` function.
As expected, it takes a single required argument. It also has a second, optional
argument that you'll probably never use. You can tell it's optional because
it's surrounded by square brackets. That's not really a PHP syntax, it's just
a common way to document optional arguments.

While we're here, take a look at the left navigation: it's full of the functions
in PHP that help you work with arrays. It's a massive list and has great stuff.
For example, let's look at :phpfunction:`array_reverse`. It takes an array
as its one required argument, reverses it, and returns it.
Let's use it to reverse ``$pets``:

    $pets = array($pancake, $pet1, $pet2, $pet3);
    $pets = array_reverse($pets);

Sure enough, the pets reverse their order when we refresh. Notice also that
I passed the ``$pets`` variable as the argument to ``array_reverse`` *and*
set the result of the function to it. This is totally legal. The
original value is passed to the function first and then the new, reversed
value is set to ``$pets`` afterwards.

Congratulations on making it through this *tough* chapter. Now celebrate
by dominating some exercises!
