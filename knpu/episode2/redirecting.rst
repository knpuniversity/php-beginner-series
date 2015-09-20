The Art of Redirecting
======================

Go back to the new pet form and fill it out again. Ok, it looks like it's
still working. Refresh a few times and check out ``pets.json``. Woh,
we have a lot of duplicate "Fidos" in our file! Each time I refreshed, the
form resubmitted and added my pet *again*. Bad dog!

In the real world, we don't want users to be able to create duplicate
records accidentally or so easily. And that's why you should redirect the
user to a different page after handling a form submit.

Remember: we *always* send back an HTTP response to the user. And so far,
a response is *always* an HTML page. But it could be something else, like
a tiny bit of directions that tell the browser to go to a totally different
URL. The browser would then make a *second* request to that URL and display
*that* HTML page. This is called a redirect.

Returning a Redirect Response
-----------------------------

After saving the new pet, let's tell the user's browser to redirect to the
homepage. To do this, use a function called ``header`` and pass it a string
with the word ``Location``, a colon, then the URL. Finish up with our trusty
``die`` statement::

    // ...

    $json = json_encode($pets, JSON_PRETTY_PRINT);
    file_put_contents('data/pets.json', $json);

    header('Location: /index.php');
    die;

And sure enough, this time when we fill out the form, we're redirected to
the homepage! Check out the network tab again in our debugging tools. It
shows us the request for the current page like always, *and* the request
of the last form submit.

Redirect: 2 Requests/Responses
------------------------------

Remember, 2 request-response cycles just happened all at once. When we submitted
the form, a POST request was sent, which we can see. But the response that our
PHP code sent back to the browser didn't contain HTML. Actually, it didn't
contain *anything*, except for this little ``Location`` line that told the
browser to redirect to the homepage. 

When the browser sees this instruction line instead of HTML, it quickly makes
a GET request to the homepage. This time, our code returns a response message
with HTML and it displays it. It looked instant, but now we know that our
browser just made 2 separate requests.

Headers
-------

Let's learn something that takes most web developers *years* to figure out.
Ready?

Don't crowd the elevator doors when it opens, people might be getting out of it.

Ok, want to learn something else that usually takes web developers years?

When our browser makes a request, the most important part is the URL. Of
course! The server needs to know which page we want! But the request also
has *other* information like our IP address and browser details. Each extra
bit if info is called a request *header*. And we can read these in PHP from
that ``$_SERVER`` array variable.

The response our code sends back *also* has extra information, called *response*
headers. A response is basically 2 pieces: the HTML and these headers. Most
of the time, we don't think about headers or responses: we just write HTML
and print some variables. This automatically becomes the content of the response
and a few important headers are set for us.

But sometimes, you *do* need to send back a response with a bit of extra
information. And in fact, when you want to tell a browser to redirect, we
need to send back a response message with a ``Location`` header. This type of 
extra information is added to the response with the ``header`` function and 
each has the same format: a header name, a colon, then the value. 
Every browser is programmed to look for the ``Location`` header.

After, I put a ``die`` statement just to stop everything right there. We
haven't printed anything yet, so the response has no content. That's perfect:
I want the browser to go somewhere else, not display this page. But even if
we did echo some HTML, the user would never see it because the browser would
redirect so quickly.

I thought you said die was bad?
-------------------------------

Ok, I admit, in `episode 1`_, I said that you should never use ``die`` except
for debugging. Yes, I'm violating that temporarily because we need to learn
a few more things before we can re-organize code and get rid of this. We'll
see that in a future screencast.

Can't Re-Submit: Mission Accomplished
-------------------------------------

We started all this redirect business because we didn't want the user to
be able to refresh a finished form and create duplicate pet data. And now,
we've done that! Refresh here: instead of re-submitting the form, it just
makes another GET request to the homepage. Whenever you process a form submit,
add a redirect by setting the ``Location`` response header.


.. _`episode 1`: https://knpuniversity.com/screencast/php-ep1/arrays3
