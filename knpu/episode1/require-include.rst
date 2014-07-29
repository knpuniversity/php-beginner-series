Using require to Include Functions
==================================

I'll show you a few more tricks with functions in a second. But right now,
let's improve our ``contact.php`` page we started earlier. First, I want
to be able to have a header that reads "Helping you find your new best friend
from over 500 pets.":

.. code-block:: html

    <h1>
        Helping you find your new best friend from over 500 pets.
    </h1>

Except, I want the number 500 to be dynamic, reflecting the true number of
pets we have in our ``pets.json`` file. I'll do this by calling our ``get_pets()``
function and passing it to PHP's ``count`` function, which will tell us how
many items are in that array:

.. code-block:: html+php

    <h1>
        Helping you find your new best friend from over <?php echo count(get_pets()); ?> pets.
    </h1>

But when we try it, it blow up big time!

    Fatal error: Call to undefined function get_pets() in /php1/contact.php on line 2

Hmm, the function works in ``index.php``, but not in ``contact.php``. Clearly,
the difference is that ``get_pets()`` actually lives in ``index.php``. And
that's totally correct. Even though it sits next to ``index.php``, when
PHP executes the contact page, it has no idea what functions or variables
might live in the index file. These two files exist in perfect isolation.

So is there a way to load the functions in ``index.php`` from ``contact.php``?
Of course! The answer is with the ``require`` statement, which tells PHP
to load & parse the contents of some other file. Require ``index.php`` at
the top of the file:

.. code-block:: html+php

    <?php
    // contact.php
    require 'index.php';
    ?>

    <h1>
        Helping you find your new best friend from over <?php echo count(get_pets()); ?> pets.
    </h1>
    
When we try it, it works... sort of. At the bottom of the page, we see our
sentence with the correct pets count. But above it is the entire ``index.php``
page, which we did *not* want. Adding ``require`` made using the ``get_pets()``
function possible, but it also brought in all the HTML from the index page
as well. What can we do?

Let's create a new file called ``functions.php``, which I'll put in a ``lib/``
directory for organization since this PHP file isn't meant to be a page that's
accessed directly like our index and contact files. Now, move the ``get_pets()``
function in here, being sure to remember your opening PHP tag:

.. code-block:: html+php

    <?php
    // lib/functions.php
    
    function get_pets()
    {
        $petsJson = file_get_contents('data/pets.json');
        $pets = json_decode($petsJson, true);
        
        return $pets;
    }

No Closing PHP Tag?
~~~~~~~~~~~~~~~~~~~

If you're screaming that I forgot the closing PHP tag, you're half-right.
If the last thing you have in a file is PHP code, adding the closing PHP
tag is optional, and it's actually better if you leave it off.
If that confuses you, go ahead and close your PHP tags for now.

.. tip::

    Why is *not* closing your PHP tags better when you don't have to? Great
    question - see http://bit.ly/IsCwPE.

Using functions.php
~~~~~~~~~~~~~~~~~~~

Now, simply ``require`` ``lib/functions.php`` from both the index and contact
files:

.. code-block:: html+php

    <?php
    // index.php
    require 'lib/functions.php';
    // ...

.. code-block:: html+php

    <?php
    // contact.php
    require 'lib/functions.php';
    // ...

Both will now have access to the ``get_pets`` function, but without any extra 
HTML, since ``functions.php`` doesn't have any. When we try them, they both work!

require, require_once, include, include_once
--------------------------------------------

Actually, there are 4 statements that can be used to execute an external
file:

* ``require``;
* ``require_once``;
* ``include``;
* ``include_once``.

The difference between ``require`` and ``require_once`` is simple: ``require``
will *always* load a file while ``require_once`` will make sure that it only
loads the file *one* time no matter how many times you call it. So if ``functions.php``
were doing some initialization and it was *really* important to only include
this file once, we might use ``require_once`` just to be safe. This becomes
more important later when you work with classes.

The other two statements are ``include`` and ``include_once``. These are
exactly the same as ``require`` and ``require_once``, except that if the
file doesn't exist, include let's the script keep running. On the other hand,
if a file imported with ``require`` is missing, a fatal error will occur
and your page will be killed immediately. In practice, I almost never use
``include``, because I have a hard time imagining a scenario where my app
is including another PHP file that only *might* exist. Does it take a break
every 15 minutes and leave my server?

To keep things simple, use ``require`` or ``require_once``, if you need to.
But realize two things. First, all 4 of these do the same thing. And second,
if you stick with us, you'll be programming sites that are so well-built
that you will practically stop using any of these. But, I'm getting ahead
of myself.
