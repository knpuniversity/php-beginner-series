Creating Functions
==================

You've come a long way already, which has included using a bunch of built-in
functions. Now it's time to make our own!

The first thing our PHP code does is read our ``pets.json`` file and decode
it into an array, which we set on our ``$pets`` variable. Let's invent a
new function called ``get_pets`` that will do this work for us and return
the finished array. Custom functions are used just like core PHP functions,
so eventually I want our code to look like this::

    <?php
    // $petsJson = file_get_contents('data/pets.json');
    // $pets = json_decode($petsJson, true);
    $pets = get_pets();

    // ...

Oh, and those two slash marks (``//``) are one of the two ways you can comment
out lines in PHP. Anything on a line after ``//`` is ignored by PHP entirely.
This is handy for temporarily removing code or writing little love notes to
your fellow developers.

Our new function can live anywhere in this file, but let's put it at the top
and out of the way. Creating a function is really easy: just say ``function``,
give it a name, add a set of parenthesis, and finish with a set of opening
and closing curly braces like we do with our 2 other special language constructs:
``if`` and ``foreach``::

    // index.php
    // ...

    <?php
    function get_pets()
    {

    }

    // $petsJson = file_get_contents('data/pets.json');
    // ...

When we call this function, any code between the curly braces will be executed.
Remember, the job of a function is usually to do some work and return a value.
Eventually, we'll return an array of pets. But to get things working, just
return a string by writing ``return``, the string, then ending things with
our usual semicolon::

    // index.php
    // ...

    function get_pets()
    {
        return 'woohoo';
    }

To debug this, we'll of course ``var_dump`` the ``$pets`` variable, since
it's set to the return value of our function. When we refresh, our string
is dumped, proving that our function is working!

Now, just copy in the logic from before and make sure the function returns
the array after decoding the string::

    // index.php
    // ...

    function get_pets()
    {
        $petsJson = file_get_contents('data/pets.json');
        $pets = json_decode($petsJson, true);
        
        return $pets;
    }

When we refresh, the whole system works! If you're wondering why this helped
us, you'll see in a moment.
