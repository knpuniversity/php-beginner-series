Centralized Configuration
=========================

The homepage is loading pet data from the database, but our contact page
isn't:

    http://localhost:8000/contact.php

It lists a different number of pets than we know we have in the database. 
Silly contact page. the problem is that ``get_pets()`` is still reading 
from the ``pets.json`` file, instead of using the database.

So instead of putting our query logic right inside of ``index.php``, why
not just update ``get_pets()`` to pull from the database?

Copy all of the database-code and paste it into ``get_pets()``, which lives
in the ``lib/functions.php`` file. Make sure to return the queried data::

    // lib/functions.php
    function get_pets()
    {
        $pdo = new PDO('mysql:dbname=air_pup;host=localhost', 'root', null);
        $result = $pdo->query('SELECT * FROM pet');
        $pets = $result->fetchAll();

        return $pets;
    }

Try out the contact page! Now that ``get_pets()`` queries the database,
this shows that we have 2 slobbery pets.

Back in ``index.php``, remove the database stuff and uncomment out the line
that calls ``get_pets()``::

    // index.php
    require 'lib/functions.php';

    $pets = get_pets();
    // ...

This works and now all our heavy-lifting lives inside functions. It's not
perfect, but our code is getting better!

Creating a Configuration File
-----------------------------

To make it easier to control your app, configuration - like your database
username and password - is usually isolated into its own file. Let's create
a new file called ``config.php``. Open up PHP and create a new associative
array with the databse connection string, the username and the password::

    // lib/config.php

    $config = array(
        'database_dsn'  => 'mysql:dbname=air_pup;host=localhost',
        'database_user' => 'root',
        'database_pass' => null,
    );

.. tip::

    DSN stands for "data source name" - the fancy name for the connection string.

If we open this file in the browser, nothing happens:

    http://localhost:8000/lib/config.php

But we expected that: the config file doesn't echo anything, it just sets
a PHP variable. This file isn't meant to be a page. Instead, we're going
to require it from other files and use this ``$config`` variable.

Let's do this in ``get_pets()``. Replace each argument to PDO with a key
from the ``$config`` variable::

    // lib/functions.php

    function get_pets()
    {
        require 'config.php';

        $pdo = new PDO(
            $config['database_dsn'],
            $config['database_user'],
            $config['database_pass']
        );

        // ...
    }

We we refresh, it still works! Remember that ``require`` is a function that
basically copies and pastes the contents of another file into this one. My
editor thinks ``$config`` is undefined, but we know better than that!

Returning from an Included File
-------------------------------

I don't *love* this. Rename ``$config`` to ``$configVars`` in ``config.php``::

    // lib/config.php
    $configVars = array(
        'database_dsn'  => 'mysql:dbname=air_pup;host=localhost',
        'database_user' => 'root',
        'database_pass' => null,
    );

This change *looks* safe. I mean, it's not like we're using this variable
anywhere inside this file. But when we refresh, things explode! We *are*
referencing the old ``$config`` variable inside ``get_pets``, but that wasn't
very obvious.

Remember how we can return values from a function? We can do the same from
included files::

    // lib/config.php
    $configVars = array(
        'database_dsn'  => 'mysql:dbname=air_pup;host=localhost',
        'database_user' => 'root',
        'database_pass' => null,
    );

    return $configVars;

Now, instead of relying on whatever we called that variable in ``config.php``,
create a new variable when you require it::

    // lib/functions.php
    function get_pets()
    {
        $config = require 'config.php';

        $pdo = new PDO(
            $config['database_dsn'],
            $config['database_user'],
            $config['database_pass']
        );

        // ...
    }
    // ...

Try it! It works again. We're using this file almost like a function: require
it and set its return value to a variable. Most included files won't have
a ``return`` line, but it's really common for configuration.

So hey, we have a configuration file! The advantage of putting all this stuff
into one spot is that you can quickly find and control all the little values
that make your app tick. This also makes our app easier to share with another
developer. If the database password on their computer is different, they
don't need to dig deep around in your code to find where you hid that.
We're starting to get organized!
