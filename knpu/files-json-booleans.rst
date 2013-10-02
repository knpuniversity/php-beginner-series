Working with Files, JSON and Booleans
=====================================

Right now our pet data array is just hardcoded and not dynamic. Eventually,
we're going to pull this array from a database and let users add
new pets to it. But before we get there, let's pretend someone
has given us a file that contains all of adorable pets available on airPupnMeow.com. 
Our goal will be to read that file and turn its contents into a PHP array 
that looks just like the one we're creating now by hand.

To make things easy, I've already prepared a file called ``pets.json``, which
I've put right inside my project directory.

.. tip::

    You can find this file in the "resources" directory of the code download.

Open up this file and see what's inside:

.. code-block:: json

    {{ get_file('resources/pets.json') }}

Ok, let's step back and talk about JSON, which has nothing to do with PHP,
except that PHP can read it. JSON is a text format that can be used to represent
structured information, like pet details:

.. code-block:: json

    {
        "name": "Chew Barka",
        "breed": "Bichon",
        "age": "2 years",
        "weight": 8,
        "bio": "The park, The pool or the Playground - I love to go anywhere! I am really great at... SQUIRREL!","filename":"pet1.png"
    }

In fact, any PHP array has a JSON string equivalent and we can
turn PHP arrays into JSON and vice-versa. In fact, there's a function called
``json_encode`` which takes an array and returns the equivalent JSON string.
Let's use it to see how our pet's array would look::

    var_dump(json_encode($pets));die;

When we refresh, we see the JSON that's equivalent to our array. And in fact,
this is exactly what we have in ``pets.json``.

.. tip::

    If you try this and your output looks a bit uglier, it's because I have
    a Chrome plugin called `JSONView`_ that adds spaces so that the JSON
    is very readable. Like with PHP, spaces don't make a difference in JSON.
    So, these two strings are equivalent, but the second is easier on the eyes!
    
    .. code-block:: json

        {"name": "Chew Barka","breed":"Bichon"}
        
    .. code-block:: json

        {
            "name": "Chew Barka",
            "breed": "Bichon"
        }

The reason JSON exists is because squiggly braces are awesome! Or maybe it's
so that different systems can communicate. Imagine if our website saved files
that were sent off and read by some completely different application. JSON
is magical because it can be read by PHP or any other language, like Ruby,
Python or JavaScript. So even if that other application is built by a bunch
of puppies, they'll be able to read our information. So, JSON is a great way
to share data.

Back in PHP, let's pretend that there's already some other part of our site
where users can submit new pets and that when they do, this ``pets.json``
file is being updated. Our job right now then is just to read its contents
and display some pretty pet faces.

Reading and Opening Files
-------------------------

So first, how can we load the contents of a file in PHP? The answer is with
the :phpfunction:`file_get_contents` function. When we pull up its documentation,
we can see how easy it is. Its only required argument is a filename. It opens
up that file and returns its contents to us as a string.

.. note::

    Remember that arguments surrounded by ``[]`` are optional. The optional
    arguments to ``file_get_contents`` are rarely used.

Easy! Let's use it and set the contents to a new variable! To see if it's
working, we'll use our trusty ``var_dump``::

    $petsJson = file_get_contents('pets.json');
    var_dump($petsJson);die;

When we refresh, we see the beautiful JSON string!

Warning and Errors in PHP
-------------------------

To experiment, let's change the filename and see what happens if the file
doesn't exist::

    $petsJson = file_get_contents('dinosaurs.json');
    var_dump($petsJson);die;

this time, we see a warning from PHP:

.. highlights::

    Warning: file_get_contents(dinosaurs.json): failed to open stream: No
    such file or directory in /path/to/index.php on line 16

PHP has both errors and warnings when things go wrong. The only difference
is that if the code mistake isn't too bad, PHP just gives us a warning and
tries to keep executing our code.

.. tip::

    PHP also has notices, which act just like warnings.

Booleans: True and False
------------------------

Here it continues, and executes our ``var_dump``, which returns false. If we
look at the documentation again, we see that ``file_get_contents`` returns
the contents of the file as a string *or* it returns ``false`` if it couldn't
read the file. ``false`` is called a Boolean, which is our fourth PHP data
type. To review, we have:

1. Strings, like ``$var = 'Hello World';``

2. Numbers, like ``$var = 5;``. And actually, numbers are sub-divided into
   integers, like 5, and floats, which have decimals like 5.12. But most of
   the time in PHP, you don't care about this.

3. Arrays, like ``$var = array('puppy1', 'puppy2', 4);``

4. And now our 4th type: Booleans. Booleans are simple because there are
   only two possible values: ``true`` and ``false``:

.. code-block:: php

    $fileExists = false;
    $iLikeKittens = true;

Like with the other 3 data types, we can assign Booleans to variables and
functions can return Booleans. ``file_get_contents`` returns a string or
``False``, which we now know is a ``Boolean``.

Decoding JSON into an Array
---------------------------

Phew! Let's get back to our furry friends. First, fix the filename. Remember that
the JSON contents we're reading from the file are a string and what we really
want is to transform that JSON string into a PHP array. We used ``json_encode``
to turn an array into JSON, so it makes sense that we can use :phpfunction:`json_decode`
to go the other direction::

    $petsJson = file_get_contents('pets.json');
    $pets = json_decode($petsJson);
    var_dump($pets);die;

When we refresh, it mostly looks right. But instead of an array, it says
something about a "stdClass". This is a PHP object, which you don't need
to worry about now. Instead, if we look at the :phpfunction`json_decode`
docs, we see it has an optional second argument, which is a bool or Boolean
that defaults to ``false``. If we change this to ``true``, the function should
return an associative array:

    $petsJson = file_get_contents('pets.json');
    $pets = json_decode($petsJson, true);
    var_dump($pets);die;    

Perfect! This is the exact array we were building by hand, so remove that
along with the ``var_dump`` statement. When we refresh, our page is back!
The JSON string is read from the file and then converted into a PHP array.
Our code is ready to iterate over each pet in that array and print out its
information by using each pet's keys. This works because the information
in the JSON file exactly matches the PHP array we had before.

If we changed the ``filename`` key for each pet in our data source ``pets.json``,
then we would also need to change it in our application to match:

.. code-block:: json

    [
        {
            "imageFilename": "pancake.png",
        },
    ]

    .. code-block:: html+php
    
        <!-- ... index.php -->

        <?php foreach ($pets as $cutePet) { ?>
            <div class="col-md-4 pet-list-item">
                <!-- ... -->

                <img src="/images/<?php echo $cutePet['imageFilename']; ?>" class="img-rounded">

                <!-- ... -->
            </div>
        <?php } ?>

Directory Path to a File
------------------------

Refresh to make sure this still works. Before we finish, let's play with
the PHP file-handling functions a little. First, move ``pets.json`` into
a new directory called ``data`` and refresh. Oh no, things blow up!

.. highlights::

    Warning: Invalid argument supplied for foreach() in /path/to/index.php on line 87

PHP no longer finds our file, which sets off a chain reaction of terrible
things! First, ``file_get_contents`` returns ``false``. Of course, ``false``
isn't a valid JSON string, so ``json_decode`` chokes as well and doesn't
return an array like it normally would. Finally, we try to loop with ``foreach``,
but ``$pets`` isn't even an array. Woh! The moral is that sometimes a mistake
in one spot will result in an error afterwards. So don't just look at the
line number of the error: look at the lines above it as well.

To fix this, we can just change our file path to ``data/pets.json``::

    $petsJson = file_get_contents('data/pets.json');

When we refresh, everyone is happy again! Notice that ``file_get_contents``
looks for files relative to the one being executed. We'll play with file
paths more later, just don't think it's magic. PHP is happily stupid: it
looks for files right in the directory of this one.

.. note::

    You can also pass an absolute file path to PHP, like ``/var/pets.json``
    or ``C:\pets.json``.

Saving to a File
----------------

And what if you want to save data to a file? If we go back to the docs for
``file_get_contents``, you'll see a related function: :phpfunction:`file_put_contents`. 
It's also really simple: you give it a filename and a string, and it saves 
that string to that file. I'll let you try this on your own in the activities. 
Don't worry about its optional arguments.

Other ways to Read and Save Files
---------------------------------

PHP has a bunch of other file-handling functions beyond ``file_get_contents``
and ``file_put_contents``. These include :phpfunction:`fopen`, :phpfunction:`fread`,
:phpfunction:`fwrite` and :phpfunction:`fclose`. For now, just forget these
exist. Except for when you're dealing with very large files, these functions
accomplish the exact same thing as ``file_get_contents`` and ``file_put_contents``,
they're just harder and weirder to use. To make matters worse, most tutorials on 
the web teach you to use these functions. Madness! You'll probably use them someday, 
but forget about them now. Working with files in PHP we need only our 2 handy functions.


.. _`JSONView`: https://chrome.google.com/webstore/detail/jsonview/chklaanhfefbnpoihckbnefhakgolnmc
