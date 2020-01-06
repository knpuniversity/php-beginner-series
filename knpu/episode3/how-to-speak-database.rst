How to Speak Database
=====================

Hey there! Things are about to get crazy because it's time to learn all about
**databases**.

We already have a data source that makes our application dynamic. It reads
and displays pet data, which happens to be stored in a file called ``pets.json``.
If we change something in this file, the site updates automatically. In a
fully-built site, you'll need to read and write lots of data - like a user's
profile, comments, purchases, or maybe forum posts so people can complain
about movies. And yea, we *could* build that site by entirely reading data
from flat files - like ``users.json`` and ``angry_movie_forum_posts.json``.

What *is* a Database?
---------------------

A database is a place to put data, just like these files. But instead we
store things in tables. And we won't be using ``file_get_contents``
and ``file_put_contents`` to read and write data, we'll use "queries", which
are kind of like human sentences that describe the data you want.

Yea, but what *is* this database thing? So first, a database is a piece of
software you run on your computer, just like a web server like Apache. People
can talk to the web server by making requests to our machine, usually to
port 80. Actually, in our tutorial, we've been using port 8000. A port is
like a door and your web server is watching for requests to port 80 so it
can process it and return a page.

Talking to a Database
----------------------

To talk to a database, we send a "query" to our computer, usually to port
3306. If the database software is running, it watches for queries coming
to this door, interprets them, then sends back the data we're asking for.
Yes, we are going to actually do this. But let's focus on the fact that a
database is just a standalone piece of software that we talk with to get data.

To make requests to a web server, we typically use a browser. To send a query
to a database, we have a few options. But the most basic is to use a command
line program called ``mysql``. MySQL is the most *common* database software
and was installed for you when you `installed XAMPP in episode 1`_.

.. tip::

    Other popular databases are `PostgreSQL`_ and `SQLite`_. They're all
    basically the same, but have subtle pros and cons.

Using the mysql Command Line Program
------------------------------------

Let's open up the command line. In Mac, I can just type "Terminal" into Spotlight
to find it. Oh, and "command line" and terminal mean exactly the same thing.
If you're using Windows, we used a terminal inside `XAMPP's control panel`_
in episode 1. I recommend using that or downloading Git, which comes with
a nice "Git Bash" terminal program. Windows *does* have a built-in terminal
called "cmd", but it's really light on features.

.. tip::

    If you are getting a connection error, make sure that MySQL server is running in XAMPP control panel!

We're going to ease into using the command line, so don't worry. You probably
*can* avoid using the terminal, but you'll be a much better developer if
you and terminal become friendly.

Ready? Type ``mysql --help``. Bah! MySQL's help information is a bit chatty.
But hey, things are working!

.. note::

    If you get a "command not found" error, make sure that MySQL is installed.
    If you're using Windows, try using the XAMPP control panel or Git Bash.
    A lot of things can go wrong during installation, so do your best to
    search around for a solution for your operating system.

This ``mysql`` program is like a browser to the database. No, it's *not*
the database, just like your browser is not the website. It just helps us
*talk* to the database, which might live on some other server.

Connecting to the Database Server
---------------------------------

If we give it the IP address to the server where the database software is
running, it'll let us write queries and send those to it. Instead of
typing this all into an address bar, we do it like this:

.. code-block:: bash

    mysql -h localhost --port=3306 -u root -p

This says "I want to talk to a database located at the IP address localhost
and go through port 3306. You should log into that database using the user
root and you should ask me what the password is."

When we hit enter, it asks us for a password. XAMPP gives the root user a
blank password, so just hit enter. If that doesn't work, try "root". We're
in!

Our login information was just sent to "localhost", which is that special
word that points right back to our own machine. It knocked on port 3306.
Since XAMPP installed the MySQL database software and configured it to look
on this port, MySQL received our details, checked the username and password
and basically said, "Welcome, come on in".

Now for Queries!

.. _`PostgreSQL`: http://www.postgresql.org/
.. _`SQLite`: http://www.sqlite.org/
.. _`installed XAMPP in episode 1`: https://symfonycasts.com/screencast/php-ep1/system-setup
.. _`XAMPP's control panel`: https://symfonycasts.com/screencast/php-ep1/system-setup#using-php-s-web-server
