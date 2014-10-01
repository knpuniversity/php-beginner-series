Preventing SQL Injection Attacks with Prepared Statements
=========================================================

Both ``get_pets`` and ``get_pet`` contain an SQL query where one part of
it is a variable. Whenever you have this situation, you're opening yourself
up for an SQL injection attack. Want to see one in action?

Change the id value in the URL of your browser to a very specific string:

    http://localhost:8000/show.php?id=4;TRUNCATE pet

Hmm, so things look ok. But refresh again. The pet is gone! In fact, check
out the database in PHPMyAdmin - the ``pet`` table is empty! Seriously, we 
just emptied the *entire* pet table by playing with the URL!

Let's dump the query in ``get_pet`` and refresh::

    function get_pet($id)
    {
        $pdo = get_connection();
        $query = 'SELECT * FROM pet WHERE id = '.$id;
        var_dump($query);die;
        $result = $pdo->query($query);

        return $result->fetch();
    }

This is an SQL injection attack:

    SELECT * FROM pet WHERE id = 4;TRUNCATE pet

By cleverly changing the URL, our code is now sending *2* queries to the
database: one to select some data and another to empty our table. If our
site were in production, imagine all the dogs that would never get walked
and cats that would never get fed salmon. All because someone injected some
SQL to drop all of our data and put us out of business. These attacks can
also be used to silently steal data instead of destroying it.

Fortunately, we can get our data back by re-running the queries from ``resources/episode3/pets.sql``
in PHPMyAdmin.

Save our Site
-------------

How do we save our site? With prepared statements. Don't worry, it's an unfriendly
term for a simple idea. Prepared statements let us build a query where the
variable parts are kept separate from the rest of the query. By doing this,
MySQL is able to make sure that the variable parts don't include any nasty
SQL code.

Using Prepared Statements
-------------------------

To use prepared statements, our code needs a little rework. First, change
the ``query`` function to ``prepare`` and put a ``:idVal`` where the id value
should go. This returns a ``PDOStatement`` object, so let's rename the variable
too.

Next, call ``bindParam`` to tell MySQL that when you say ``:idVal``, you
really mean the value of the ``$id`` variable. To actually run the query,
call ``execute()``::

    // lib/functions.php
    // ...
    function get_pet($id)
    {
        $pdo = get_connection();
        $query = 'SELECT * FROM pet WHERE id = :idVal';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam('idVal', $id);
        $stmt->execute();

        return $stmt->fetch();
    }

It's a bit longer, but it works! We built the query, but replaced the dynamic
part with a placeholder: a word that starts with a colon. This isn't any
PHP magic, it's just how prepared statements work. The ``prepare()`` function
does *not* actually execute a query, it just returns a ``PDOStatement`` object
that's ready to go. To actually make the query, we call execute, but not
before calling ``bindParam`` for each placeholder with the real value.
To get the data from the query, we finish up by calling either ``fetch()``
or ``fetchAll()``.

This is *actually* how I recommend you write all your queries, whether you
have any variable parts of not.

Let's repeat the change in ``get_pets()``. Just write the query with the
LIMIT placeholder, bind the parameter, call ``execute()`` to make the query
and  ``fetchAll()`` to get the data back. Simple!

.. code-block:: php

    // lib/functions.php
    function get_pets($limit = null)
    {
        $pdo = get_connection();

        $query = 'SELECT * FROM pet';
        if ($limit) {
            $query = $query .' LIMIT :resultLimit';
        }
        $stmt = $pdo->prepare($query);
        $stmt->bindParam('resultLimit', $limit);
        $stmt->execute();
        $pets = $stmt->fetchAll();

        return $pets;
    }

Refresh the homepage to make sure it's working. Oh crap, it's not! But there's
also no error.

Debugging Errors
----------------

Whenever there's a problem with a query, we can configure PHP to tell us
about it, instead of staying silent like it is now. Find ``get_connection()``
and add one extra line to configure our PDO object::

    function get_connection()
    {
        // ...

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

Refresh now! Ah, a nice error! So this is what it looks like if your query
has an error. The problem is actually subtle and really not that important.
Pass a third argument to ``bindParam``::

    $stmt->bindParam('resultLimit', $limit, PDO::PARAM_INT);

*Now* it works. This tells MySQL that this value is an integer, not a string.
This almost never matters, but it does with LIMIT statements. So like I said
before, don't give this too much thought.

When you *do* have errors with a query, the best way to debug is to try the
query out first in PHPMyAdmin, then move it to PHP when you have it perfect.

Moving On!
----------

Ok team, we are *killing* it. In just a few short chapters, we've updated almost
our entire application to use a database. The only part that *doesn't* use
the database is the new pet form, which we'll fix early in the next episode.

Use your new-found power for good: create some tables in PHPMyAdmin and start
querying for data. Don't forget to put up your fence to protect against SQL Injection
attacks, so that the adorable poodle, fluffy Truncate Table, doesn't cause you problems.

Seeya next time!
