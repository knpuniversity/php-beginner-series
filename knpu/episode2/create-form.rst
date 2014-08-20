We deserve to Create a Form
===========================

Ok, let's build this form! Let's leave PHP alone for a second and put together
some good ol' HTML to create a form with name, breed and weight text fields.
And hey, why not a bio textarea field too so we can get to know these pets!

.. code-block:: html+php

    <h1>Add your Pet</h1>

    <div class="form-group">
        <label for="pet-name" class="control-label">Pet Name</label>
        <input type="text" name="name" id="pet-name" class="form-control" />
    </div>
    <div class="form-group">
        <label for="pet-breed" class="control-label">Breed</label>
        <input type="text" name="breed" id="pet-breed" class="form-control" />
    </div>
    <div class="form-group">
        <label for="pet-weight" class="control-label">Weight</label>
        <input type="number" name="weight" id="pet-weight" class="form-control" />
    </div>
    <div class="form-group">
        <label for="pet-bio" class="control-label">Pet Bio</label>
        <textarea name="bio" id="pet-bio" class="form-control"></textarea>
    </div>
    
    <!-- ... -->

I'm adding some divs and classes here that use the Twitter Bootstrap CSS
that's included in this project. So, nothing to worry about - this just makes
our site a little prettier! And hey, that's important too!

.. note::

    I used ``<input type="number" ... />`` for the ``weight`` field because
    newer browsers will render this with some extra nice-ness. Old browsers
    just render a normal text fields. This is an HTML5 field.

In PHP's eyes, the important thing is the ``name`` attribute on each field.
It can be anything, but this will be how we get each field's value in PHP.

We also need to wrap all of the fields in a ``form`` tag. Set its ``action``
attribute to point back to this same page and definitely don't forget the
``method="POST"`` part. I'll show you why that's so important in a second:

.. code-block:: html+php

    <h1>Add your Pet</h1>

    <form action="/pets_new.php" method="POST">
        <!-- all the form guts from before ... -->
    </form>
    
    <!-- ... -->

Finally, you're going to need a cool-looking submit button in the form!

.. code-block:: html+php

    <button type="submit" class="btn btn-primary">
        <span class="glyphicon glyphicon-heart"></span> Add
    </button>

Refresh. Wow! Now that's a sweet form.

Submit that Form
----------------

Ok, let's fill out a few fields and submit.

Hmm, nothing happens. The URL is still the same, and now the form is blank
again. Actually, something amazing just happened. Go back to the network
tab in our debug tools. When we pressed "Add", our browser sent an HTTP request
to the server. And this time, it had even *more* information on it. It had
all the values from our form!

GET and POST Requests
~~~~~~~~~~~~~~~~~~~~~

It's different in another way too. The "Request Method" is POST - and that's
because of the ``method="POST"`` part of our form tag. So there are 2 *types*
of HTTP requests our browser can send. GET request are used on almost every
page and POST requests are used on most form submits. The difference doesn't
really matter yet, but GET requests are for reading data, like when you click
on a link and read the next page. POST requests are for sending data, like
a form submit.

.. tip::

    There are actually other HTTP methods like PUT, HEAD and DELETE. These
    are mostly useful only if you're building or using an API. Don't worry
    about that at all right now.

So when we submit, our browser sends a POST request that has all the values
on it. If we could just read that, we'd be as dangerous as a loose puppy
at a hot dog stand!
