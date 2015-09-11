System Setup
============

When you develop a website, it usually looks something like what you've been
watching me do. You open up a PHP file in some sort of editor, then point
your browser at some web address that executes the PHP file and shows you
the output. But of course you've been practicing that diligently in the activities :).
Now, it's time to get your computer setup so that you can program for realz!

Setting up your computer correctly is one of the hardest things you have to do...
I mean really it sucks. It's a necessary evil and every computer is different,
but we'll try to make this as easy as possible.

But first, we're going to learn a little bit about the invisible hamsters in wheels that
run the web.

The Anatomy of Requesting a Page
--------------------------------

Initially, there's you, on a browser, going to our domain - AirPup.com/index.php. 
When you hit enter, the magic starts. At this moment, our
browser is making a "request", which means we're sending a message into the
Interwebs. This message says that we're requesting the HTML for the ``index.php``
file on the AirPup.com domain. That file may be sitting on a completely different
computer thousands of miles away--enjoying a beach you will never see. Eventually, our 
request message gets to that server, the ``index.php`` file is executed, and a 
"response" message full of HTML is sent back. Our browser gets that message and displays the
HTML. Request, response, that's how the web works. It's like a game of telephone:
you talk via your browser directly to a computer, tell it what you want, and it responds with it.

IP Addresses and the DNS Fairy
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

In order for the request to find its way to our server, a few magic things
happen. First, a fairy called DNS turns AirPup.com into an IP address. There's
more magic behind this, but an IP address is the address to a computer, just
like you have a unique address to your house. With it, our request knows
exactly which tubes to go through to find that server.

Web Server Software
~~~~~~~~~~~~~~~~~~~

When it gets there, it knocks on the door and says "I'm a web request, is
there a website here?". Any machine that hosts a web site will have a piece
of software running on it called a "web server". Don't get confused: the request
has arrived at a server, which you should think of as a single machine, just
like your computer. The "web server" is a just a program that runs all the
time and waits for requests like ours to knock on the server's door.

.. tip::

    There are many web servers available, but the most popular are `Apache`_,
    `Nginx`_ and `PHP's built-in web server`_.

At this point, the web server software opens the door and looks at our request
message for AirPup's homepage. It says, "Yes, I do serve this website and
its files live on this server at some specific location." That location is
something you configure when you setup your web server. But let's pretend
that the web server software is looking at ``/var/www/airpup.com`` for the
AirPup files. Or if you're on Windows, perhaps it's looking at ``C:/sites/airpup.com``
or something like that. I'm just making these paths up - the important thing
is that when the web server sees the request for AirPup.com, it knows that
the files from this site live in a certain directory on the machine.

Requesting a File
~~~~~~~~~~~~~~~~~

Ok, just one more step! Let's pretend that this imaginary server out there
on the web is actually my computer that you're watching right now. We usually
think of servers living in huge rooms with blinking lights and the ability
to withstand the zombie apocalypse, but my computer can also be a server.
So when I type the domain into my browser, instead of going 1000 miles away
across the web to some other machine, the request starts to go out and then
comes back and knocks on the door to my computer. Let's also assume that I
have some web server software running and it knows to look for the AirPup
files right in this directory where I've been working.

So starting simple, if I change my URL to ``http://AirPup.com/css/main.css``,
I see my CSS file in the browser. The web server software sees that we're
requesting the file ``/css/main.css`` and so it opens up that file and sends
a response to my browser with its contents. This looks simple, but we
know that there are a bunch of players involved including my browser, the
DNS fairy, the server, which happens to be my computer, and finally the web
server software that grabs the file I've requested and "serves" it back to
my browser. A web server is just something that serves files across the web.
We send a message to request a file, it serves us a message back with that
file's contents. Basically, this whole crazy system is setup to let other
people access files on my computer.

Serving and Executing PHP Files
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

But when the file we're requesting ends in ``.php``, something extra happens.
Your web server software still finds the file like normal. When I put ``index.php``
in my browser, it finds the ``index.php`` in my directory. But instead of
just returning that file unprocessed, with all of our PHP code, it executes
that code. When all the code has been run, the final result is served as
the response.

If we need another page, just create a new file called ``contact.php``, put
some simple code in there, and put ``contact.php`` in your address bar::

    <?php echo 'Contact Us!'; ?>

.. tip::

    In modern web development, we have a more robust way of handling multiple
    pages. You'll learn about that in an upcoming episode.

So what do you think will happen if we rename this file to ``contact.html``
and access it in the browser? Will the PHP code run? Will it just disappear?

When we try it, we get what *seems* like a blank page. But if you view the
HTML source, there's our PHP code! Because the file didn't end in ``.php``,
our web server software simply returned the raw, unprocesssed file. The only
reason we didn't see it at first is that the opening PHP tag looks like
broken HTML, so our browser tries to process it.

Setting up Your Computer
------------------------

Ok! Now it's your turn! If this seems a bit complex, don't worry. You already
know more about how the web works than 99.9% of people that use it everyday.
And there's a shortcut I'll show you to get all this setup easily.

.. note::

    `PHPTheRightWay.com`_ has some additional notes on setting up your computer,
    including an alternative approach that uses a Virtual Machine. That's
    a great solution, but requires more setup than we want to cover here.

Install PHP
~~~~~~~~~~~

First, install PHP on your computer. PHP is basically just an executable
file. Not an executable file like Chrome or iTunes that opens up and has
a cute GUI, more like an executable that you can run from the command line.
If you're not used to the command line, it's ok: we'll ease into it.

Since things seem to be most complex in Windows, I'll switch to Windows 7
for the rest of this chapter. Installing PHP is different in each system,
so I'll have you follow along with me and some installation details for your
operating system.

There are a lot of ways to install PHP, but the easiest is `XAMPP`_, which
works on Windows, Mac or Linux.

.. note::

    If you're on a Mac and use `MacPorts`_ or `Homebrew`_, you can install
    PHP through those. If you're on Linux and have a package manager like
    ``apt-get`` or ``yum``, use it to install PHP.

Download `XAMPP`_ for your operating system. The PHP version doesn't matter,
just get at least PHP 5.4. With the power of TV, I'll make our download look
super fast. Now to follow along with the install instructions.

In addition to PHP, this also installs Apache - the most common web server
software - and MySQL - the most common database. We won't worry about these
right now.

To check if things are working, enter ``http://localhost`` in your browser
and choose your language if it asks. You should see a bright page. If you 
don't, don't panic. First, open up the XAMPP control panel and make sure 
Apache is running. If that's not the problem, ignore it for now. You may 
have already had Apache installed, which means they're fighting each other 
to answer the door. This is especially common on a Mac, which comes with a 
version of Apache and PHP already installed. We're not going to use Apache 
at all right now. So if your setup seems broken, ignore it!

Diagnosing how the XAMPP page works
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

By the way, how does this page work? In the address bar, instead of something
like ``airpup.com``, our domain is just ``localhost``. If that seems odd
to you because it has no ``.com`` or ``.net`` ending, good call! ``localhost``
is a special hostname that - on every machine in the world - is a pointer
back to this same machine. So instead of going out to the DNS fairy and asking
what the IP address of ``localhost`` is, the request immediately bounces
right back to the computer you are using. ``localhost`` is a handy and very special shortcut
for web developers.

Next, the request knocks on the door and Apache answers. Instead of pointing
at a file, the URL in your browser may be just pointing at a directory called
``xampp``. When we point to a directory, Apache is usually configured to look
for an ``index.php`` file and render that. In fact, if we add ``index.php``
to the URL, nothing changes - this was the true file being displayed the whole time.

    http://localhost/xampp/index.php

Apache knows *where* on our computer the files of ``localhost`` live and looks
for the ``xampp/index.php`` file there. So where is this directory? If we read
the XAMPP docs, it's ``C:\xampp\htdocs``. If we go there, we see a ``xampp``
subdirectory and an ``index.php`` file. Mystery solved. The directory where
your server reads from is commonly called the ``document root`` or ``web root``
and its location will vary and can be configured.

Building our Project
~~~~~~~~~~~~~~~~~~~~

Ok, enough with that! I *could* start building my project right inside the
document root, but I'm going to put it somewhere else entirely, like a new
``Sites`` directory in my home directory. Create it if it's not there already.

.. tip::

    Having a ``Sites`` folder in your home directory is a very common setup
    for Macs.

Apache doesn't ever look in here, so if I create an ``index.php``
file, it's not accessible via my web browser. If we wanted to use Apache,
we'd need to reconfigure the document root to point here. But actually, we
won't do that: I'll show you an easy trick instead.

But first, go to the KnpUniversity GitHub to download the code that goes along
with this course. Choose the `server_setup`_ branch, download the zip file,
unzip it into the Sites directory and rename it to ``AirPup``. This is the
code for the project we've built so far.

Using PHP's Web Server
~~~~~~~~~~~~~~~~~~~~~~

Next, I'm going to turn Apache completely off. You don't need to do this,
I just want to prove that we're not going to use it. Apache is great, but
learning to use & configure Apache can bring its own headaches. I don't want
us to worry about those right now.

When I refresh our page, it says that the server isn't found. Our request
knocks on the door to our server, but since Apache is not running, no one
answers and the request fails.

We *do* need a web server, but instead of using Apache, we're going to use
PHP's itself. Since version 5.4, it has a built-in web server that's *really*
easy to use. You won't use it on your real production server that hosts
your finished website because it's not as fast as web servers like Apache.
But for developing locally, it's wonderful.

First, open up a command line or terminal. Actually, XAMPP's control panel
has a terminal we can use, which also sets up some variables and paths that
make life easier. I'll use that.

.. tip::

    In OS X, open up spotlight and type ``terminal``. It's also in
    ``Applications/Utilities/Terminal``.

Move into the directory you created. Of course, this looks different on
Windows and your directory will live in a different location.

.. tip::

    In OS X and Linux, if you created a ``Sites/airpup`` folder in your home
    directory, then you can move into it by typing ``cd ~/Sites/airpup``.

Once here, type the following:

.. code-block:: bash

    php -S localhost:8000

and hit enter. If your screen looks like mine, you're in luck! If you have
an error or see something different, scroll down to the `PHP Server Troubleshooting`_
section in the script below to help you debug it.

Assuming it worked, just let this sit, copy the URL it printed, paste it
into your browser, and add ``index.php`` to the end. Woh, it works! PHP
is now our web server, and it looks right in this directory for its files.

To turn the server off, just press ``Ctrl+c`` or close the window. To turn
it back on, run the command again. Don't forget to start this before you work.

.. tip::

    By pressing "up", the terminal will re-display the last command you ran.

Port 8000 and Port 80
~~~~~~~~~~~~~~~~~~~~~

The ``:8000`` is called the port. A computer has many ports, which are like
doors from the outside. By default, when a web request goes to a server, it
knocks on port 80 and a web server, like Apache, is listening or watching
that door. Most URLs don't have a ``:80`` on the end, only because your browser
assumes that the request should be sent to port 80 unless you tell it otherwise.
In our situation, we started the PHP web server and told it to listen on
port 8000, not on port 80. There wasn't any special reason we did this and
we could have listened on port 80 as well, as long as some other web server
software weren't already watching that door. Because we did this, if a request
goes to port 80, our PHP web server won't be there to answer. By adding ``:8000``,
the request goes to port 8000, our PHP web server is waiting, and everything
continues like normal.

Congratulations! You have our PHP project running from your computer. You
can start playing with the files to see what happens. Any editor can be used
to edit the PHP files, since they're just plain text. But do yourself a favor
and download a good editor: I recommend `PHPStorm`_, `NetBeans`_ or `Sublime Text`_
if you have a Mac. PHPStorm will tell you when you have a syntax error, help
you remember the arguments to PHP functions, and a lot more. It has a free
trial so check it out. And no, they didn't even pay me to say that: they just 
have a great editor. But if they are listening... :).

PHP Server Troubleshooting
--------------------------

Everything working? Cool, you can skip this.

Having problem getting the built-in PHP web server running? Here are the
most common problems:

Command php not Found
~~~~~~~~~~~~~~~~~~~~~

When you type the ``php`` command inside your terminal, you may get an error
that basically says that the command ``php`` isn't found or recognized. PHP
is an executable file that lives in a specific directory on your system. Normally,
you can only execute files when you are actually *inside* the same directory
as that file. But some files are registered in "global" paths. This means
that when you type ``php``, your computer knows exactly where on your system
to find that file. If you've installed PHP and you're getting this error,
this is the problem!

There are 2 fixes, and unfortunately they vary based on your system. First,
to be safe, close and re-open your terminal. Sometimes this will fix things.

If it doesn't, here are the 2 options:

#. Read the Xampp documentation and find out where the PHP executable lives.
   Then, instead of typing simply ``php``, you could type the full path to
   the executable file. This would mean typing something like:

   .. code-block:: bash

       C:\xampp\php\php.exe -S localhost:8000

#. The above is a temporary fix, as it's pretty annoying to need to always
   include this full path. The real fix is to add the directory of your PHP
   executable to your system paths. In Windows, for example, there is a system
   configuration that says "when I type things at the command line, look in
   these directories for those files". If we can add the ``C:\xampp\php``
   directory to that list, we're in luck! See `how to access the command line for xampp on windows`_.

Running the command just returns a big set of directions
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

If you have an older version of PHP, then running ``php -S localhost:8000``
won't work. Instead, it will just print a big set of options back to you.
If this happens, check your version of PHP by running ``php -v``. If the
version you have is 5.3.* or lower, you need to upgrade it. The command we're
running in PHP only works for version 5.4.0 and higher. And that's really
ok, 5.3 versions are quite old by now :).

.. _`Apache`: http://httpd.apache.org/
.. _`Nginx`: http://wiki.nginx.org/Main
.. _`PHP's built-in web server`: http://www.php.net/manual/en/features.commandline.webserver.php
.. _`PHPTheRightWay.com`: http://www.phptherightway.com/#getting_started
.. _`XAMPP`: http://www.apachefriends.org/en/xampp.html
.. _`MacPorts`: http://www.macports.org/
.. _`Homebrew`: http://brew.sh/
.. _`PHPStorm`: http://bit.ly/1a5qdPD
.. _`NetBeans`: https://netbeans.org/
.. _`Sublime Text`: http://www.sublimetext.com/
.. _`how to access the command line for xampp on windows`: http://stackoverflow.com/questions/10753024/how-to-access-the-command-line-for-xampp-on-windows
.. _`server_setup`: https://github.com/knpuniversity/php-beginner-series/tree/server_setup
