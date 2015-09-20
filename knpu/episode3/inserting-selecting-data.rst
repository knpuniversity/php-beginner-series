INSERTing and SELECTing Data
============================

How do we add data to a table? With a query! Whenever you want to add a new
row to a table, use the ``INSERT INTO`` query:

.. code-block:: sql

    INSERT INTO pet (name, breed) VALUES ("Chew Barka", "Bichon");

Heck, let's add another one:

.. code-block:: sql

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
