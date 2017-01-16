Using Query Parameters
======================

It's time to give each pet their very own page. At this stage, a new page
means a new file - so create a ``show.php`` file and copy in the require
statements for ``functions.php``, the header and the footer:

.. code-block:: html+php

    <!-- show.php -->
    <?php require 'lib/functions.php'; ?>
    <?php require 'layout/header.php'; ?>

    <h1>Display 1 pet</h1>

    <?php require 'layout/footer.php'; ?>

.. tip::

    Eventually, we'll learn a strategy called "routing" that makes creating
    new pages easier and gives you tons of control over how your URLs look.

Every page follows a familiar pattern: we do some work at the top - like querying
the database - and then we use the variables we created in the rest of the
HTML to print things. Here, our "work" will be to query for only *one* pet
in the database.

But first, let's create a link from each pet on the homepage to this file.
To tell the page *which* pet we want to display, let's add ``?id=`` to the end
of the URL and print out this pet's ``id``:

.. code-block:: html+php

    <!-- index.php -->
    <!-- ... -->

    <h2>
        <a href="/show.php?id=<?php echo $cutePet['id'] ?>">
            <?php echo $cutePet['name']; ?>
        </a>
    </h2>
    <!-- ... -->

Refresh and click on the link. We're taken to the new page with a little
``?id=`` part on the URL. That's called a query parameter and it's the easiest
way to pass some extra data to a page.

Using Query Parameters
----------------------

The HTTP request coming into the server now contains a little extra information
via this query parameter. So how can we read this in PHP? Whenever you need
some data from the incoming request, the answer is *always* one of those
`superglobal variables`_. We used ``$_POST`` to get data submitted in a
form and ``$_SERVER`` to figure out if this is a GET or POST request.

Query parameters are accessed via the ``$_GET`` superglobal. Let's dump this
whole variable:

.. code-block:: html+php

    <?php
    // show.php
    var_dump($_GET);die;

Just like the other superglobals, this is an associative array. We can add
more values in the URL by adding an & sign between each:

    http://localhost:8000/show.php?id=5&foo=bar&page=10

Now ``$_GET`` has 3 items in it.

.. tip::

    Query parameters always start with a ``?`` and then every key-value
    pair is separated by an ``&`` afterwards.

So let's grab the id key from ``$_GET``:

.. code-block:: html+php

    <?php
    // show.php
    require 'lib/functions.php';
    $id = $_GET['id'];
    // ...

You know the drill from here! We'll query the database for this one pet and
use that information to build the page. But wait! Should we build the query
right here or put it in a function? Easy choice: a function will help keep
things organized. Call an imaginary ``get_pet()`` function and pass it the
``$id``:

.. code-block:: html+php

    <?php
    // show.php
    require 'lib/functions.php';
    $id = $_GET['id'];
    $pet = get_pet($id);
    // ..

And before we even think about creating that function, we already know what
it will return: an associative array with the details for just *one* pet.
Let's build out this page with that in mind. To save some typing, I've started
this file in the code download at ``resources/episode3/show.php``. I'll copy
its contents into this middle of our page and fill in a few missing pieces:

.. code-block:: html+php

    <!-- show.php -->
    <!-- ... -->

    <h1>Meet <?php echo $pet['name']; ?></h1>

    <div class="container">
        <div class="row">
            <div class="col-xs-3 pet-list-item">
                <img src="/images/<?php echo $pet['image'] ?>" class="pull-left img-rounded" />
            </div>
            <div class="col-xs-6">
                <p>
                    <?php echo $pet['bio']; ?>
                </p>

                <table class="table">
                    <tbody>
                        <tr>
                            <th>Breed</th>
                            <td><?php echo $pet['breed']; ?></td>
                        </tr>
                        <tr>
                            <th>Age</th>
                            <td><?php echo $pet['age']; ?></td>
                        </tr>
                        <tr>
                            <th>Weight</th>
                            <td><?php echo $pet['weight']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

.. _`superglobal variables`: http://php.net/manual/en/language.variables.superglobals.php

