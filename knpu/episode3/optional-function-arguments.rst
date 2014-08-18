Optional Function Arguments
===========================

But right now, the contact page is broken because ``get_pets()`` has a required
argument, and we're not passing it anything. But what should we pass here?
1000? 1 million? We really want *no* limit, but that's not possible right
now.

So let's be clever and pass 0:

.. code-block:: html+jinja

    <!-- contact.php -->
    <!-- ... -->

    <h1>
        ...your new best friend from over <?php echo count(get_pets(0)); ?> pets.
    </h1>

Next, add an ``if`` statement in ``get_pets()``. Let's only add the limit
if the ``$limit`` variable is set to something other than zero. We can do
this by first creating a ``$query`` variable. Then, if we have a limit, add
a little bit more to the new variable::

    // lib/functions.php
    function get_pets($limit)
    {
        // ..

        // THIS IS A HUGE SECURITY FLAW - TODO - WE WILL FIX THIS!
        $query = 'SELECT * FROM pet';
        if ($limit != 0) {
            $query = $query .' LIMIT '.$limit;
        }
        $result = $pdo->query($query);
        // ...

    }

Try it out! The contact page shows us the right number once again. Our function
just got a bit more powerful.

Using Things that Look & Smell Like true/false in an If Statement
-----------------------------------------------------------------

Whenever we have an ``if`` statement, we always pass it a boolean: 
either a variable or little bit of code that equates to ``true`` or ``false``. 
When we use the ``!=`` operator, PHP compares the values and feeds either true
or false to the ``if`` statement. That's old news for us.

But let's try something. What if we *just* put the ``$limit`` variable in
the ``if`` statement::

    // lib/functions.php
    // ...

    if ($limit) {
        $query = $query .' LIMIT '.$limit;
    }

So ``$limit`` isn't a boolean: it's either the number 3 or 0, depending on
who's calling it. So will this work? Will we get an error?

Refresh the contact page. No error - and it shows 4 pets. Now go to the homepage.
We see 3 pets. Things are still working!

So you *can* pass something other than ``true`` or ``false`` to an ``if``
statement. And when you do, PHP looks at what's there and tries to figure
out if it looks and smells more like true or more like false.

For example, empty things like an empty string or the number zero becomes
false. Everything else becomes true.

+--------------------+------------+
| Value              | Equates to +
+====================+============+
| 0                  | false      |
+--------------------+------------+
| empty string       | false      |
+--------------------+------------+
| empty array        | false      |
+--------------------+------------+
| null               | false      |
+--------------------+------------+
| false              | false      |
+--------------------+------------+
| 5                  | true       |
+--------------------+------------+
| foo                | true       |
+--------------------+------------+
| array(5, 10)       | true       |
+--------------------+------------+
| -25                | true       |
+--------------------+------------+
| true               | true       |
+--------------------+------------+

Even a negative number or a string that has only spaces in it becomes ``true``,
because these aren't really empty. So when we pass ``0`` for the ``$limit``
argument, it looks like ``false`` and doesn't enter the ``if`` statement.

Optional Argument
-----------------

But we can go further and make the ``$limit`` argument completely optional.
How? Just assign it a value when you declare the argument in ``get_pets()``::

    function get_pets($limit = 0)
    {
        // ...
    }

This doesn't automatically change anything. But now we can remove the argument
we're passing to ``get_pets()`` in ``contact.php``:

.. code-block:: html+jinja

    <!-- contact.php -->
    <!-- ... -->

    <h1>
        ...your new best friend from over <?php echo count(get_pets()); ?> pets.
    </h1>

Prove that it works by going to the contact page.

The Nothing Value: null
-----------------------

Let's change the ``0`` default value to ``null``. ``null`` is the value that
is equal to "nothing", and I used it earlier as my database password, since
my MySQL server doesn't have a password.

Both 0 and ``null`` will look like ``false`` in the ``if`` statement, so the
code will act the same. Since ``null`` means nothing, it just feels a little
bit better to use it as the default value for an optional argument.

The Function Signature
----------------------

By the way, the name and arguments to a function are called the "signature".
When you hear people talking about a function's signature, it's just a
smart-sounding way to refer to the arguments that function has and also the
value it returns. So now you'll sound even smarter when talking with your 
cool new programmer friends.


