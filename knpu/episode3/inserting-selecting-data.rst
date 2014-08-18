INSERTing and SELECTing Data
============================

How do we add data to a table? With a query! Whenever you want to add a new
row to a table, use the ``INSERT INTO`` query:

.. code-block:: sql

    INSERT INTO pet (name, breed) VALUES ("Chew Barka", "Bichon");

Heck, let's add another one:

    INSERT INTO pet (name, breed) VALUES ("Spark Pug", "Pug");

``INSERT INTO`` means "add a new row to this table". The syntax is a little
odd, but always the same: INSERT INTO, the table name, a comma list of the
fields you want to fill in, the word VALUES, then a comma list of their values.

SELECTing Data
--------------

Now that the data is in there, we just need to figure out how to read it.
Reading data always starts with the same word, which you'll see more than
*anything* else: SELECT. Try selecting *all* of the data from the ``pet``
table:

.. code-block:: sql

    SELECT * FROM pet;

There they are! And even in a nice table. In this simple form, SELECT shows
*every* row and *every* field in a table.

Primary Keys: The very Special id Field
---------------------------------------

Check out that ``id`` column. Our INSERT query sent values for ``name`` and
``breed``, but not ``id``. That's allowed, and you can even setup a column
to have a default value, just for that situation.

But every table has one special column called the primary key. This column
is usually an integer that auto-increments. If we don't send a value for
it, MySQL just picks 1, 2, 3, 4 and so on. That's really handy, because the
primary key of each row needs to be unique in the table.

Let's add another pet, but leave both the ``id`` and ``breed`` columns blank:

.. code-block:: sql

    INSERT INTO pet (name) VALUES ("Pico de Gato");

Use SELECT to see all 3 rows:

.. code-block:: sql

    SELECT * FROM pet;

The ``id`` column just keeps on auto-incrementing, but this breed is empty.
What *are* you Pico do Gato?

SELECT only some Columns
------------------------

A ``SELECT`` query has a few other tricks too, like being able to return only
specific columns instead of everything. Just change the ``*`` to a list of
what you want:

.. code-block:: sql

    SELECT id, name FROM pet;

SELECT only some Rows with WHERE
--------------------------------

One of the most common things to do is filter by some condition. Suppose
we *only* want to return rows where the ``id`` column is *greater* than 1.
We do that by adding a ``WHERE`` clause to the end of the query:

.. code-block:: sql

    SELECT id, name FROM pet WHERE id > 1;

You can add filters like this on any column and even use some pretty complex
logic. We'll see more examples later, but since MySQL is so popular, you'll
find plenty of stuff online to help.

Putting it All Together
-----------------------

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
| bio                | varchar |         |
+--------------------+---------+---------+
| image              | varchar | 255     |
+--------------------+---------+---------+

Beyond choosing the data type, each column has some other options. These
are less important, but you can google them if you're curious.

So now our table is setup and we have an easy way to see and play with our
data. Behind the scenes, queries are being sent to our MySQL server software,
PHPMyAdmin is just taking care of that for us.
