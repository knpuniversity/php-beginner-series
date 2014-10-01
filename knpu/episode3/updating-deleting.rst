Updating, Deleting and Putting it All Together
==============================================

When you're all done running queries, just type quit.

Now let's put this all together. MySQL is a database software that runs on a
server and listens to port 3306. We tell the ``mysql`` program that there
is database software running on some computer and that it's waiting for us
to talk to it on port 3306. In this case, the database is right on our computer,
so we use ``localhost`` instead of the IP address of some other machine.
We also give it a username and password that it uses to log into the MySQL
server.

We can actually shorten the command that opens the connection to MySQL:

.. code-block:: bash

    mysql -u root -p

We're removed the ``-h`` and ``--port`` options, because the program uses
``localhost`` and port ``3306`` by default.

Once we've connected to the MySQL server, it contains many databases. We
created one, and we can get a full list using the ``SHOW DATABASES`` query:

.. code-block:: sql

    SHOW DATABASES;

To actually make queries to *our* database, we have to use it:

.. code-block:: sql

    USE air_pup;

Inside our database, we created one table. We can see *all* our tables using
the ``SHOW TABLES`` query:

.. code-block:: sql

    SHOW TABLES;

If you want to see what columns a table has, try the ``DESCRIBE`` query:

.. code-block:: sql

    DESCRIBE pet;

Nice! But here's a secret: all those commands and queries we just reviewed
aren't really *that* important. Yea, you need to understand them, but you
won't be creating databases or even tables that often. 99% of the time, you'll
be adding, updating, reading or deleting data. So if you want to get dangerous
with MySQL, focus on the INSERT, UPDATE, SELECT and DELETE commands.

UPDATE a row
------------

Let's see an UPDATE query in action by capitalizing Spark Pug's breed. The
``id`` of his row is 2, so we'll add a ``WHERE`` clause to the end of the
query so that *only* his row changes:

.. code-block:: sql

    UPDATE pet SET breed='PUG' WHERE id = 2;

Check it out by selecting all the rows:

.. code-block:: sql

    SELECT * FROM pet;

DELETE a row
------------

So actually, you can add a ``WHERE`` clause to the end of a ``SELECT``, ``UPDATE``
*or* ``DELETE`` query. Let's remove Pico de Gato by matching on her name:

.. code-block:: sql

    DELETE FROM pet WHERE name = 'Pico de Gato';

Yep, looks like that works! So that's basically it! You're now pretty dangerous
with MySQL. In a second, we'll get real crazy by talking to MySQL from inside
PHP.

PHPMyAdmin: Database GUI
------------------------

So far, I've been making you communicate with MySQL directly using its native
language: queries. But there are also some pretty nice GUI's to help you
see your data, build queries, and even make tables.

The most popular is probably PHPMyAdmin. It's actually a website, writen
in - surprise! - PHP! It runs on your local computer, and if you installed
XAMPP, you can already access it by going to ``http://localhost/phpmyadmin``:

.. code-block:: text

    http://localhost/phpmyadmin

Oh, and if this doesn't work, make sure that Apache is running. For XAMPP, you
can do this in its control panel - we `turned Apache off in episode 1`_, just
to prove how we weren't using it for our site.

PHPMyAdmin is easy, and there's plenty of docs online for it. Let's navigate
to *our* database and table to check out the data. It even helps us filter
the results and show the query that it's using with MySQL behind the scenes.

While we're here, let's add the rest of the columns we need on the ``pet``
table. These will be the same as what we have in the ``pets.json`` file, so
we'll add ``age``, ``weight``, ``bio`` and ``image``:

+--------------------+---------+---------+
| Column Name        | Type    | Length  |
+====================+=========+=========+
| age                | varchar | 255     |
+--------------------+---------+---------+
| weight             | integer | 4       |
+--------------------+---------+---------+
| bio                | text    |         |
+--------------------+---------+---------+
| image              | varchar | 255     |
+--------------------+---------+---------+

Beyond choosing the data type, each column has some other options. These
are less important, but you can google them if you're curious.

So now our table is setup and we have an easy way to see and play with our
data. Behind the scenes, queries are being sent to our MySQL server software,
PHPMyAdmin is just taking care of that for us.

.. _`turned Apache off in episode 1`: http://knpuniversity.com/screencast/php-ep1/system-setup#using-php-s-web-server
