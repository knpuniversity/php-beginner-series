Limiting the Number of Results
==============================

Our app would be a little more fun to play with if we had some more interesting
pets in our ``pet`` table. So I made a file with some SQL queries that insert
some new furry friends. Open up the ``resources/episode3/pets.sql`` file:

.. code-block:: sql

    TRUNCATE TABLE `pet`;

    INSERT INTO `pet`
        (`id`, `name`, `breed`, `age`, `weight`, `bio`, `image`)
        VALUES
        (1, 'Chew Barka', 'Bichon', '2 years', 8, 'The park, The pool ...', 'pet1.png');

Cool. ``TRUNCATE`` is the mysql keyword you use when you want to empty a table.
It's handy when you're developing - but try not to use this on the production database,
you'd probably end up in the dog house. After that, we just have a bunch of INSERT queries. 
Copy the contents. Now open up PHPMyAdmin, click the SQL tab and paste it in there. 
And voila! We've got 4 pets.

.. tip::

    You can also execute all the queries in this file from the command line:

    .. code-block:: bash
    
        mysql -u root -p air_pup < resources/episode3/pets.sql

When we refresh the homepage, we see our 4 pets. In fact, if we had 1 million
pets in our table, they would *all* load on this page. That would be way more
dog food than I can afford!

Instead, no matter *how* big this table gets, let's *only* show 3 pets on
the homepage. To do this, we can change our query to tell MySQL to only return
3 rows. This is done by adding a ``LIMIT`` at the end::

    // lib/functions.php

    function get_pets()
    {
        // ...

        $result = $pdo->query('SELECT * FROM pet LIMIT 3');
        $pets = $result->fetchAll();

        return $pets;
    }

When we refresh now, only 3 pets! Hey, that's one more little MySQL trick. But
``get_pets()`` is kind of broken now - it *always* returns only 3 results.
So our contact page says that we only have 3 pets. That's not true!

Instead of hardcoding 3 in the query, let's add a ``$limit`` argument to
the function::

    // lib/functions.php
    function get_pets($limit)
    {
        // ...
    }

Now we can use this to dynamically create the query string. Technically,
this is simple. But wait! What I'm about to show you is a *huge* security
hole, I mean **huge**! Take the ``$limit`` variable and add it to the end
of the string. This is called concatenation::

    // lib/functions.php
    function get_pets($limit)
    {
        // ...

        // THIS IS A HUGE SECURITY FLAW - TODO - WE WILL FIX THIS!
        $result = $pdo->query('SELECT * FROM pet LIMIT '.$limit);

        // ...
    }

Now, open up ``index.php`` and pass ``3`` as an argument to ``get_pets()``::

    // index.php
    require 'lib/functions.php';

    $pets = get_pets(3);

Now refresh. We still have 3 pets!

SQL Injection Attacks
---------------------

But don't celebrate - we have a big security bug! Whenever you create a database
query that has some variable part to it, you open yourself up to an SQL injection
attack. This is probably the most common attack on the web and one mess-up
will give an attacker full access to do *anything* to your databse.

I'll explain this attack more in a few minutes, and we'll close this security
hole.
