Request, New Page and - Hey, You Welcome Back!
==============================================

Hi there! I knew you'd be back! Learning to be a PHP programmer is a lot
of work, but totally worth it. So, keep going: you're getting more dangerous
with each minute you spend practicing.

Getting the Code, Starting the Web Server
-----------------------------------------

We're going to keep coding on the project from `episode 1`_. If you don't have
that code, just download it from the screencast page and unzip it. Once you've
done that, we just need to start the PHP web server.

Open a terminal and move into the directory where the unzipped files live.
I already unzipped the files in a ``Sites/php`` directory. Start the PHP
web server by typing the following:

.. code-block:: bash

    php -S localhost:8000

Great! Now just put that URL in your browser and voila!

    http://localhost:8000

.. tip::

    Having issues? Check out our `server setup`_ chapter in `episode 1`_!

What Secrets lie on the HTTP Request?
-------------------------------------

In `episode 1`_, we learned that the web works via requests and responses. Our
browser sends an HTTP request message into the interwebs for airpup.com/contact.php.
This eventually finds our server where it scratches on the door. And with any
luck, some web server software like Apache will be listening, open the door,
look in a certain directory for the ``contact.php`` file and process all
the PHP treats . . . I mean tags. The final HTML is called an HTTP response, 
and is sent from the server back to our browser.

So it all starts when *we* send that HTTP request message. But actually,
that message has a whole lot more information than just the hostname and
page we want. It also has our IP address, info on which browser we're using
and the values of fields when we submit a form.

Peeking at Requests
-------------------

Let's peek at these by going to the debugger on our browser. Click on the
network tab and refresh.

.. tip::

    You may need to enable network tracking before refreshing, which the
    network tab will ask you to do. If you don't see any debugging tools,
    make sure you're using a good browser. I recommend Google Chrome.

Each line here is an HTTP request that was just made by our browser. The top
is the request for ``contact.php``. The other requests are for the CSS, JS
and images on the page. Yep, on every page load, your browser is actually
making a *bunch* of requests into the internet tubes.

If you click on ``contact.php``, we can actually see how *this* HTTP request
message looks. Yep, it's a lot of stuff. That ``User-Agent`` is what browser
you're using and ``Accept-Language`` is how the browser tells the server
what languages you speak. It's not important now, but we can get any of this
information from inside PHP!

We need a New Page!
-------------------

I want to build a form so a user can rent out their pet's love to others.

Let's start by creating a new page. How do we do that? Just create a new
file called ``pets_new.php`` and scream some text out:

.. code-block:: html

    HI I AM A PAGE! 
    
    SQUIRREL!

To see us screaming at us, change the URL to ``/pets_new.php``:

    http://localhost:8000/pets_new.php

So every new page is just a new file. In a future episode, I'll teach you
a way to create URLs and pages that's much fancier than this. But don't worry
about that quite yet.

Let's make this page properly fancy by copying in the ``header.php`` and
``footer.php`` require lines:

.. code-block:: html+php

    <?php require 'layout/header.php'; ?>

    HI I AM A PAGE!
    
    SQUIRREL!

    <?php require 'layout/footer.php'; ?>

Refresh to see a page that is only a little ugly. Progress! And a little
Twitter Bootstrap markup makes this look a tiny bit better.

.. code-block:: html

    <div class="container">
        <div class="row">
            <div class="col-xs-6">
                <h1>Add your Pet</h1>
            </div>
        </div>
    </div>

Navigation like a Real Site
---------------------------

Hmm, and wouldn't it be nice if we had a link to this page from our top menu?
Let's change "About" to say "Post" and link to this page. This code lives
in ``header.php``. We can also make "Home" *actually* go to the homepage.

.. code-block:: html+php

    <!-- layout/header.php -->

    <ul class="nav navbar-nav">
        <li class="active"><a href="/">Home</a></li>
        <li><a href="/pets_new.php">Post</a></li>
        <li><a href="#contact">Contact</a></li>
        ...
    </ul>

Refresh. Go team! We have a working nav like a real site!


.. _`episode 1`: https://knpuniversity.com/screencast/php-ep1
.. _`server setup`: http://knpuniversity.com/screencast/php-ep1/system-setup
