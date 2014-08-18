Talking to Databases in PHP
===========================

If you don't have the code for the project downloaded yet, get it now. After
it downloads, unzip it. Perfect! All we need to do now is start the built-in
PHP web server so we can execute our code. Open up a terminal, move into
the directory where you just unzipped the code, and start the server:

.. code-block:: bash

    php -S localhost:8000

Unless I've messed something up, I should be able to go to ``http://localhost:8000``
and see our site. There it is!

Connecting to MySQL in PHP
--------------------------

We're about to take a *huge* step by talking to our database from *inside*
our code. Actually, making queries from PHP is simpler than what we did in
the last few chapters. But just like before, step 1 is to connect to the
server. Open up ``index.php`` and create a new PDO object. This shows off
a new syntax which we will cover in a second::

    // index.php

    $pdo = new PDO('mysql:dbname=air_pup;host=localhost', 'root', null);
    // ...

This creates a connection to the server, but doesn't make any queries. It's
the PHP version of when we typed the first ``mysql`` command in the terminal
to the server.

Before we dissect it, let's query for our pets! We're going to use a function
called ``query`` but with a new syntax. Set the result to a ``$result`` variable.
Next, call another function called ``fetchAll`` and set it to a ``$rows``
variable. Dump ``$rows`` so we can check it out::

    // index.php

    $pdo = new PDO('mysql:dbname=air_pup;host=localhost', 'root', null);
    $result = $pdo->query('SELECT * FROM pet');
    $rows = $result->fetchAll();
    var_dump($rows);
    // ...

Ready to see what the data looks like? Refresh your homepage.

Hey, it's an array with 2 items: one for each row in the ``pet`` table.
Each item is an associative array with the column names as keys. For convenience,
it also repeats each value with an indexed key, but we won't need that extra
stuff, so pretend it's not there.

What's really cool is that the array already looks like the one that ``get_pets``
gives us. If we temporarily comment out that function and use the array from
the database by renaming ``$rows`` to ``$pets``, our page should work!!

.. code-block:: php

    // index.php
    // ...
    $pdo = new PDO('mysql:dbname=air_pup;host=localhost', 'root', null);
    $result = $pdo->query('SELECT * FROM pet');
    $pets = $result->fetchAll();

    require 'lib/functions.php';

    //$pets = get_pets();

    // ...

Refresh! No errors, and the page shows 2 pets. Sure, they're not very interesting
since our 2 pets don't have age, weights, bios or images, but we could fill
those in easily in PHPMyAdmin.
