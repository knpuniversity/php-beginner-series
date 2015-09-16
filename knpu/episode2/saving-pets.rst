Saving Pets
===========

Ok, let's talk about saving pets. No, not like *rescuing* them, though that's
really cool too. I'm talking about being able to submit our new pet form
and saving that pet information somewhere so that it shows up on our site.
I want to make our pet list truly dynamic!

We haven't talked about databases yet, and we're not using one. But actually,
the pet data our site needs *is* being stored in a simple ``pets.json`` file.
And this file *is* something we can read from and even update. And hey, that's
basically all a database really does. So if we can figure out how to update
the ``pets.json`` file each time we submit this form, we're in business!

First, we can re-use our ``get_pets`` function to get an array of all of
the *existing* pets from the file. Let's add this right at the bottom of
our form processing code::

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ...
    
        $pets = get_pets();
        var_dump($name, $breed, $weight, $bio);die;
    }

Next, create an associative array that represents the new pet that's being
added. Make sure the keys you're using match the existing pets from the file.
We don't have age or image fields yet, so just set those to be blank::

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ...
    
        $pets = get_pets();
        
        $newPet = array(
            'name' => $name,
            'breed' => $breed,
            'weight' => $weight,
            'bio' => $bio,
            'image' => '',
            'age' => '',
        );
        
        var_dump($name, $breed, $weight, $bio);die;
    }

Ok! Now just add that new pet to the ``$pets`` array::

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // ...
    
        $pets = get_pets();
        
        $newPet = array(
            'name' => $name,
            'breed' => $breed,
            'weight' => $weight,
            'bio' => $bio,
            'image' => '',
            'age' => '',
        );
        
        $pets[] = $newPet;
        
        var_dump($name, $breed, $weight, $bio);die;
    }

Remember that the empty square brackets tells PHP we want to add something
to the ``$pets`` array, but we don't care what the items key is. It'll choose
a unique number for us.

Saving the Pets to pets.json
----------------------------

Now, ``$pets`` has all the existing little fur balls, *and* our new one. 
It basically represents *what* we want to save to ``pets.json``.

Let's do it! First, turn ``$pets`` back into JSON with PHP's ``json_encode``
function. To *actually* save the file, use another PHP function: ``file_put_contents``::

    // ...
    $pets[] = $newPet;

    $json = json_encode($pets);
    file_put_contents('data/pets.json', $json);

This is basically what the ``get_pets`` function does, only in reverse!
``json_encode`` turns the array into a string, and then we save it back to
the file.

Let's try it! Fill out the form and submit. An error!

    Call to undefined function get_pets()

Ah, woops! That function lives in the ``functions.php`` file. If we want
to use it, we need to ``require`` that file:

.. code-block:: html+php

    <?php
    require 'lib/functions.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // ... 
    }

Ok, refresh and re-post the form. Hmm, it looks like it did nothing. But
that's not true! We submitted the form, our code detected this was a POST
request, we saved the new stuff to ``pets.json``, and then the page continued
rendering the blank form. There weren't any fireworks, but I think this worked!

Go to the homepage to find out for sure! We didn't give it an image, but
there's our pet. We don't even have a database, and we already have a dynamic
app.

Readable JSON!
--------------

If you look at ``pets.json``, it got flattened onto one line. That's ok!
Spaces and new lines aren't important in JSON, and PHP saved without any
extra whitespace. Again, that's fine really.

But since I *did* like my file better when it was readable, give ``json_encode``
a second argument of ``JSON_PRETTY_PRINT``::

    $json = json_encode($pets, JSON_PRETTY_PRINT);

Fill out our form again. Hey, now ``pets.json`` looks awesome again. We are 
really good at training this digital pet :) ``JSON_PRETTY_PRINT``
is called a *constant*, which is kind of like a variable, exept that it's
magically available everywhere, doesn't have a ``$``, and its value can't
change. You won't use them often, so don't worry about them too much.
