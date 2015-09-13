Adding a very Simple Layout
===========================

Ok, let's improve one more thing by giving ``contact.php`` the same HTML
layout as our homepage. To do this, just isolate the header and footer into
their own files, say ``layout/header.php`` and ``layout/footer.php``. Move
all of the HTML from the top of the index page into header and the stuff
from the bottom into footer:

.. code-block:: html+php

    <!-- layout/header.php -->
    <!DOCTYPE html>
    <html lang="en">
    <head>...</head>
    <body>
    <!-- header code here... -->

.. code-block:: html+php

    <!-- layout/footer.php -->
    <footer>...</footer>
    </body>
    </html>

Require the header near the top of each page and the footer after our page-specific
code:

.. code-block:: html+php

    <?php
        // index.php
        // ... the big PHP code block at the top
    ?>
    <?php require 'layout/header.php'; ?>

    <!-- all of the HTML and PHP code from the middle  ...-->
    
    <?php require 'layout/footer.php'; ?>

.. note::

    Repeat the same thing in the contact.php file.

And just like that, our two pages are sharing the layout!

You're going Far!
-----------------

Woh! You just learned a ton: coming from the basics of PHP to using arrays,
functions, foreach loops, complex if statements, true/false boolean values,
user-defined functions, require statements and more. We also got your system
setup so that you can develop and try your own code locally.

So congratulations, but keep going! There's so much more that we need to
cover, like how to submit a form, talk to a database, and use query parameters.
And to be serious developers, we also need to organize our project better.
As nice as the ``functions.php``, ``header.php``, and ``footer.php`` files
are, real developers organize things in more sophisticated ways. But
keep working and we'll get there!

See ya next time!
