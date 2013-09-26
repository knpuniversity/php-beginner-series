Arrays Level 2: Associative Arrays
==================================

Let's leave our array of pets behind and focus on one wonderful pet: Pancake
the Bulldog! So far, we're just printing out the name of each pet, but Pancake
has too much personality for that and deserves her own full bio! We'll print
bios for every pet eventually, but let's just focus on Pancake first, because
she's awesome!

I know a lot of information about Pancake, including her age, weight, bio and
the filename to a photo. Let's store all of this information in an array and
print it manually at the top of our pet list:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $pancake = array('Pancake the Bulldog', '1 year', 9, 'Lorem Ipsum', 'pancake.png');
    ?>
    
    <div class="container">
        <div class="row">            
            <div class="col-lg-4 pet-list-item">
                <h2><?php echo $pancake[0]; ?></h2>

                <img src="/images/<?php echo $pancake[4]; ?>" class="img-rounded">

                <blockquote class="pet-details">
                    <?php echo $pancake[1]; ?>
                    <?php echo $pancake[2]; ?> lbs
                </blockquote>

                <p>
                    <?php echo $pancake[3]; ?>
                </p>
            </div>

            <!-- the foreach with $pets ... -->
        </div>
    </div>

I'm using the array for convenience here, but eventually we'll query a database,
which will give us an array of information just like this. When we refresh,
we see Pancake displayed at the top of our list. And yes, we're weighing our
dogs in pounds because we're from the US. Feel free to write kilograms if you like that
better!

One big problem is that this is hard to read: it's not obvious that the 2
index is weight or that 4 is the image filename. And if we decided that we
don't want to include weight anymore, Pancake's bio and filename keys change
and the whole thing blows up!

.. highlights::

    Notice: Undefined offset: 4 in /path/to/project/index.php on line 114

We could fix this, but the whole system is messy.

Specifying Array Keys
---------------------

There's a better way of course! Instead of letting the array assign keys
for us, let's tell the array exactly what key we want for each item:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $pancake = array(
            'name' => 'Pancake the Bulldog',
            'age'  => '1 year',
            'weight' => 9,
            'bio' => 'Lorem Ipsum',
            'filename' => 'pancake.png'
        );
    ?>

First, I'll put each item on its own line. This is meaningless, I'm just trying
to keep my code a bit more readable. When you want to control the key, put
the key to the left of the item, followed by the equal and greater than signs.
I sometimes call this an "equal arrow". Notice that these keys are strings,
so we surround them by quotes. The end result looks like a map: the key on
the left points to the value on the right.

Now all we need to do is update our code to use the keys. Again, now that
they are strings, we surround them by quotes:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->
    
    <div class="container">
        <div class="row">            
            <div class="col-lg-4 pet-list-item">
                <h2><?php echo $pancake['name']; ?></h2>

                <img src="/images/<?php echo $pancake['filename']; ?>" class="img-rounded">

                <blockquote class="pet-details">
                    <?php echo $pancake['age']; ?>
                    <?php echo $pancake['weight']; ?> lbs
                </blockquote>

                <p>
                    <?php echo $pancake['bio']; ?>
                </p>
            </div>

            <!-- the foreach with $pets ... -->
        </div>
    </div>

Refresh and success!

When you take control of the indexes, or keys, of an array, the array is
known as an associative array. The name makes sense if you imagine associating
each item in the array with a specific key. When an array is full of items
where we *don't* specify the keys, it's known as a boring "indexed" array.
I *may* have added the word boring.

    associate: array('name' => 'Pancake', 'weight' => 9);

    indexed:   array('Pancake', 9);

.. tip::

    Each item in an "indexed" still has an array key, but it's auto-assigned
    to a number, like 0, 1 or 2. We saw this in the last chapter.

Adding items to an Array after Creation
---------------------------------------

So far we're adding all the items to our array right when we create it. But
how could we add more items to the array later? Let's add a new ``breed``
to the array *after* it's been created:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $pancake = array(
            'name' => 'Pancake the Bulldog',
            'age'  => '1 year',
            'weight' => 9,
            'bio' => 'Lorem Ipsum',
            'filename' => 'pancake.png'
        );
        
        $pancake['breed'] = 'Bulldog';
    ?>

Let's render it and refresh to make sure it works. Nice!

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->
    
    <blockquote class="pet-details">
        <span class="label label-info"><?php echo $pancake['breed']; ?></span>
        <?php echo $pancake['age']; ?>
        <?php echo $pancake['weight']; ?> lbs
    </blockquote>

Adding Items to an Indexed Array
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

While we're on the topic, can we also add more items to an indexed array
after it's been created? Following what we did with the associative array,
we could guess that it might look something like this:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <?php
        $pet1 = 'Chew Barka';
        $pet2 = 'Spark Pug';
        $pet3 = 'Pico de Gato';

        $pets = array($pet1, $pet2, $pet3);
        
        $pets[] = 'Kitty Gaga';
    ?>

But what key do we use between the square brackets? We could manually put
in 3 (``$pets[3] = 'Kitty Gaga';``) since we can count the items in the array
and see what the next key will be. But it would be better if PHP could automatically
assign the key, just like it did for the other items.

To have PHP choose the index, we leave it exactly like this:

    $pets[] = 'Kitty Gaga';

When you put nothing between the square brackets, it tells PHP to choose the
key for us, which it does by picking the first available number (3 in this case).

In the next chapter, we're going to get crazy and use associative arrays
to print more details on all of our pets. But first, let's practice!
