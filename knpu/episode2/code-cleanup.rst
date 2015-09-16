Cleaning up with save_pets
==========================

Hey, I have an idea: let's clean up our code a little by creating a ``save_pets``
function in ``functions.php``::

    function save_pets()
    {

    }

Copy in the 2 lines that encode the pets array and writes the file::

    function save_pets()
    {
        $json = json_encode($pets, JSON_PRETTY_PRINT);
        file_put_contents('data/pets.json', $json);
    }

Ah, my editor is highlighting the ``$pets`` variable because it's undefined.
A function only has access to the variables you create *inside* of it, and,
yep, there's definitely no ``$pets`` variable here. It lives back in ``pets_new.php``.

Adding Arguments to Our Functions
---------------------------------

We already know that functions can have arguments - we just saw that with
``header``, which has one argument. We can make ``save_pets`` require an
argument too - just add a ``$petsToSave`` variable between the parenthesis
of that function::

    function save_pets($petsToSave)
    {
        $json = json_encode($pets, JSON_PRETTY_PRINT);
        file_put_contents('data/pets.json', $json);
    }

Now, call the function from ``pets_new.php``. When we do, PHP will *require*
us to pass it an argument. Give it the ``$pets`` variable::

    $pets[] = $newPet;

    save_pets($pets);

    header('Location: /');
    die;

Accessing an Argument from inside a Function
--------------------------------------------

Ok, now dump ``$petsToSave`` so we can see what's going on::

    function save_pets($petsToSave)
    {
        var_dump($petsToSave);die;
        $json = json_encode($pets, JSON_PRETTY_PRINT);
        file_put_contents('data/pets.json', $json);
    }

Fill out the form. Bam! We see the big pets array. Change the argument to
``save_pets`` to just a little bit of text::

    $pets[] = $newPet;

    save_pets('this is some text!');

    header('Location: /');
    die;

Refresh! Now our text is dumped out. So whatever we pass to ``save_pets``
becomes the ``$petsToSave`` variable. Change the argument back to ``$pets``::

    $pets[] = $newPet;

    save_pets($pets);

    header('Location: /');
    die;

Inside ``save_pets``, we can pass ``$petsToSave`` into ``json_encode``. Oh,
and I just invented this variable name - we could have called it anything::

    function save_pets($petsToSave)
    {
        $json = json_encode($petsToSave, JSON_PRETTY_PRINT);
        file_put_contents('data/pets.json', $json);
    }

Moment of truth! Refresh. We're back on the homepage with the pet we just
added. Brilliant!

Why Use Functions?
------------------

Things work the same as before, so why did I make you add this function?
Moving logic into functions gives us 2 really cool things.

First, if we need to save pets somewhere else, we can just re-use this function.
We're already doing this with ``get_pets``, which I think we're calling in
at least 3 places.

Second, by moving these lines into a function with a name, it helps explain
*what* they do. If I didn't write this code, I might have trouble figuring
out what it does or its purpose. But when it's inside a function called
``save_pets``, that helps.

We'll go through this process of writing code and reorganizaing it over and
over again. Our site is measured by more than just whether or not it works:
you also want your code to be easy to understand and easy to make more changes
too.

Building great things *and* doing it well, *that's* where you're going. And
you've just finished another episode you crazy developer! Congrats! Now
build something and keep learning with us.

Seeya next time!
