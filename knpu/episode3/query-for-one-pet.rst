Querying for One Pet
====================

Ok, now to create that ``get_pet()`` function! Add it in ``functions.php``::

    // lib/functions.php
    // ...

First, let's build the query. Instead of returning *every* row in a table,
we can use the WHERE clause trick we learned earlier to return *only* the row
whose id equals the ``$id`` variable argument. Like before, this query has
a variable part to it, so it **is a security** flaw. But we're going to
fix it in a few seconds::

    function get_pet($id)
    {
        $query = 'SELECT * FROM pet WHERE id = '.$id;
    }

Understanding Function Scope
----------------------------

Now we have the query, but we *don't* have the ``$pdo`` object. It's created
and lives in ``get_pets()``, but we can't access it here. Each function is
its own little universe and you only have access to the arguments passed
in and any variables you create in that function.

Let's see what I mean. Create a ``$test`` variable outside of the ``get_pet()``
function and then try to dump it inside of it::

    // lib/functions.php
    // ...

    $test = 'works?';
    function get_pet($id)
    {
        var_dump($test);die;
        $query = 'SELECT * FROM pet WHERE id = '.$id;
    }

Yep, that explodes! The variable ``$test`` does not exist. Like I said, each
function is its own, isolated universe. When you talk about what variables
you have access to and why, we often use the word "scope". If I say something
about the "function scope", I'm talking about all of the variables that my
function has access to. It's just another one of those techy terms that
really describe something simple. Now we can remove this test variable.

We know that copying and pasting the code from ``get_pets()`` into ``get_pet()``
is code duplication and a recipe for future problems. So how can we get the
``$pdo`` variable in ``get_pet()``?

One answer is to make it accessible anywhere by moving that stuff to a
new function called ``get_connection``. Let's do that::

    function get_connection()
    {
        $config = require 'config.php';

        $pdo = new PDO(
            $config['database_dsn'],
            $config['database_user'],
            $config['database_pass']
        );

        return $pdo;
    }

With variables, you have to worry about scope and what you have access to.
But functions can be called from anywhere. Call this function from ``get_pets()``::

    function get_pets($limit = null)
    {
        $pdo = get_connection();
        // ... all the same logic
    }

Now, use it again from inside ``get_pet()``. To finish this, use
the same ``query()`` function we saw before. But at the end, use ``fetch()``
instead of ``fetchAll()``::

    function get_pet($id)
    {
        $pdo = get_connection();
        $query = 'SELECT * FROM pet WHERE id = '.$id;
        $result = $pdo->query($query);

        return $result->fetch();
    }

Use ``fetchAll`` to return multiple rows from the database and use ``fetch``
when you just want *one* row, like here.

Refresh! It works! I never doubted you. This looks good, but we *have* to
address our big security hole next.
