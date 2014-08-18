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
variable parts are kept separate and are escaped to prevent injection. For
example, check out this imaginary situation::

    $name = "Santa's helper";
    $sql = "SELECT * FROM pet WHERE name = '".$name."'";

Forget SQL injection, this query will have a syntax error because the apostrophe
in "Santa's" closes the quotes in the query:

    SELECT * FROM pet WHERE name = 'Santa's helper';

But with prepared statements, the final query that's sent to MySQL would
have an extra slash in it:

    SELECT * FROM pet WHERE name = 'Santa\'s helper';

The backslash is called the escape character and tells MySQL to treat the
next character like a boring letter and not a special string-ending quote.
This query *would* run successfully. And by the way, this same trick works
with PHP strings::

    $name = 'Santa\'s helper';

.. note::

    I avoided this before by using double quotes around the string. Remember
    that double quotes and single quotes do the same things and only have
    very minor differences.

