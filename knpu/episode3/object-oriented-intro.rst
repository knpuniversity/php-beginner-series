Object-Oriented Intro: Classes and Objects
==========================================

But we just accomplished more than our first query in PHP. We also just saw
one of the most fundamentally important concepts to almost any programming
language: objects.

To talk to the database, we first open a connection using a *class* called
``PDO``. This returns an object, which we set to the ``$pdo`` variable. We
haven't talked about classes or objects yet, but it's not important for you
to understand them. Just know that an *object* is another PHP data type.
So in addition to strings, numbers, arrays and booleans, we have objects.
We'll learn a little about them now, and a lot more in future episodes.

That ``PDO`` thing is called a class, but you can think of it as a function
that has arguments like anything else. Its first argument is a special string
that tells it to connect to a MySQL server that's running on our computer
and to use the database called ``air_pup``. The second and third arguments
are the username and password to the server.

But instead of returning an array, boolean or string, this function returns
a PDO *object*. Let's dump the variable and refresh::

    var_dump($pdo);die;

This doesn't tell us much, but proves that this is a PDO object. For now,
you can think of the words "class" and "object" as meaning the same thing.
We'll explore these more in future episodes.

Calling Functions on Objects
----------------------------

Over the first few episodes, we've used a lot of functions, including core
PHP functions like ``array_reverse()`` and our own like ``get_pets()``. We
can call a function from anywhere in our code, so we say that they are available
"globally".

But some functions *aren't* global: they live *inside* an object and we call
them *through* that object using this arrow (``->``) syntax::

    $result = $pdo->query('SELECT * FROM pet');

Here, ``query`` is *not* one of those "global" functions: it belongs to the
PDO object. If we try to call it like a global function, it doesn't exist!

.. code-block::php

    // index.php

    $pdo = new PDO('mysql:dbname=air_pup;host=localhost', 'root', null);
    $result = query('SELECT * FROM pet');
    // ...


.. code-block:: text

    Call to undefined function query()

Add the ``$pdo->`` back so that we're calling a query on that object. Now
the page works again.

A Peek into Object-Oriented Programming
---------------------------------------

Classes and objects belong to something called object-oriented programming,
which might be the most important programming concept you'll ever learn.
But I don't want to get too far into it now. Just be aware that we'll be
working with a few objects. And each object has its own set of functions that
we can call, like ``query`` and ``fetchAll``.

The Old-School mysql functions
------------------------------

I have to warn you: there *is* another way to talk to MySQL in PHP that doesn't
use classes and objects. The code looks something like this, and almost every
tutorial on the web will teach you this way::

    mysql_connect('localhost', 'root', null);
    mysql_select_db('air_pup');
    $result = 'SELECT * FROM pet');
    $row = mysql_fetch_array($result);

See it? Simple enough? Great. Now, *never* **ever** use this. These functions
are old. In fact, they're said to be "deprecated", which means that a future
version of PHP will remove these. I want you to be a *great* developer, so
we're going to skip straight past these and use the newer, better method
and leave this old stuff in the past.
