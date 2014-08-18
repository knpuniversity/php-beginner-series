Queries, Databases and Tables: Oh My!
=====================================

On this screen, we're now talking directly to the MySQL database software
that's running on our computer. It's kind of like talking to a dumb robot,
like Siri! We can ask it questions and give it commands, as long as we use 
a simple syntax it understands.

Let's try saying hi. Each command should end with a semicolon:

.. code-block:: text

    Hi Database;

Ok, that didn't work. Try this instead:

.. code-block:: sql

    SELECT "Hi Database";

Awesome! SELECT is the command we use to get data out of MySQL, and even
though this isn't very impressive, we'll do crazy things with it later.

And hey, this is our first "query"! The mysql program we're inside of sent
this message out of our computer and back in through port 3306 where the
MySQL server software read it and responded back with this little table.
A query isn't a question: it's a human-like language of commands that say
"show me this data", "update that data" or "delete these things".

Try another query:

.. code-block:: sql

    SHOW DATABASES;

I know, using sentences to do things is just weird - it'll feel better over
time. And no, my cat *didn't* accidentally step on the caps lock - the shouting
is on purpose. MySQL commands are usually written in all caps like this, but
it's totally unnecesary - the same command works in lowercase:

.. code-block:: sql

    show databases;

Creating a Database
-------------------

MySQL is the database software we're talking to. And actually, it can hold
many different databases, which are like separate dividers or folders for
data. If you were building 10 different sites, you'd have 10 different databases.
I already have several others on my machine.

We're building a site, so let's create a database called ``air_pup``:

.. code-block:: sql

    CREATE DATABASE air_pup;

The name ``air_pup`` isn't important - we could use anything. Send a query
to list the datbases now:

.. code-block:: sql

    SHOW DATABASES;

There it is! This fancy new database is like an empty directory: there's
nothing in it yet but it's ready to go!

Hey! We already know 3 MySQL commands, or queries: SELECT, CREATE DATABASE
and SHOW DATABASES; And there really aren't that many more to learn.

Creating a Table
----------------

Let's move into our database:

.. code-block:: sql

    USE air_pup;

Any queries we make now will be run against the ``air_pup`` database.

A directory on your computer holds files. So what lives inside a database?
Tables! If you think of a database like a spreadsheet, then each sheet or
page is like a table. One sheet might hold pet data and have fields for
name, breed, bio and other stuff. We might also have a second sheet that
holds user data, with fields like name, address and favorite ice cream.
In the database world, each of these is a table.

So before we start tossing pets into the database, we need to create a table
and tell MySQL exactly what fields this it will have. We're going to do this
the hard way first - you'll thank me later when you *really* understand this
stuff!

Like all things, a table is created by asking the database politely. In other
words, a query:

.. code-block:: sql

    CREATE TABLE pet(
        id int(11) AUTO_INCREMENT,
        name varchar(255),
        breed varchar (100),
        PRIMARY KEY (id)
    ) ENGINE=InnoDB;

This is long and ugly. First, we say we want to create a table with the name
``pet``. Next, like a spreadsheet, we give the table some columns. The big
difference is that each column *also* has a data type, which says if it should
hold numbers, text or something diferent. The ``id`` column is an ``int``
type, so it'll hold numbers.

The ``varchar`` type means that this column can store up to 255 characters
of text. If we try to put more in it, the 256th character will get chopped off!

There are other details that I don't want you to worry about yet. The important
parts are that we're calling the table ``pets``, giving it 3 columns and
setting a data type on each column. Besides ``int`` and ``varchar``, MySQL
has a lot of other types. But honestly, you'll use these and just a few others
most of the time.

I used multiple lines to make this one long query. MySQL is totally ok with
this - it just waits for a semicolon before actually sending the query.

Ok, run it! The message says "Query OK, 0 rows affected". That's not very
exciting, considering how much typing we did - but this *is* good!

Try another query to see all the tables in the database:

.. code-block:: sql

    SHOW TABLES;

Ok, only 1 table so far, but great start! We've created our database and
a table. To celebrate, let's give it a treat by putting some data in it!
