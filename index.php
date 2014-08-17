<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.ico">

    <title>AirPupnMeow.com: All the love, none of the crap!</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">AirPupnMeow</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a href="#about">About</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li class="dropdown-header">Nav header</li>
                            <li><a href="#">Separated link</a></li>
                            <li><a href="#">One more separated link</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" placeholder="Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" placeholder="Password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-success">Sign in</button>
                </form>
            </div>
            <!--/.navbar-collapse -->
        </div>
    </div>

    <div class="jumbotron">
        <div class="container">
            <?php
                $cleverWelcomeMessage = 'All the love, none of the crap!';
                $pupCount = count($pets);
            ?>

            <h1><?php echo strtoupper(strtolower($cleverWelcomeMessage)); ?></h1>

            <p>With over <?php echo $pupCount ?> pet friends!</p>

            <p><a class="btn btn-primary btn-lg">Learn more &raquo;</a></p>
        </div>
    </div>

    <?php
        $pet1 = array(
            'name' => 'Chew Barka',
            'breed' => 'Bichon',
            'age' => '2 years',
            'weight' => 8,
            'bio' => 'The park, The pool or the Playground - I love to go anywhere! I am really great at... SQUIRREL!',
            'filename' => 'pet1.png'
        );

        $pet2 = array(
            'name' => 'Spark Pug',
            'breed' => 'Pug',
            'age' => '1.5 years',
            'weight' => 11,
            'bio' => 'You want to go to the dog park in style? Then I am your pug!',
            'filename' => 'pet2.png'
        );

        $pet3 = array(
            'name' => 'Pico de Gato',
            'breed' => 'Bengal',
            'age' => '5 years',
            'weight' => 9,
            'bio' => 'Oh hai, if you do not have a can of salmon I am not interested.',
            'filename' => 'pet3.png'
        );

        $pancake = array(
            'name' => 'Pancake the Bulldog',
            'age'  => '1 year',
            'weight' => 9,
            'bio' => 'Lorem Ipsum',
            'filename' => 'pancake.png'
        );
        $pancake['breed'] = 'Bulldog';

        $pets = array($pet1, $pet2, $pet3, $pancake);
    ?>

    <div class="container">
        <div class="row">
            <?php foreach ($pets as $cutePet) { ?>
                <div class="col-lg-4 pet-list-item">
                    <h2><?php echo $cutePet['name']; ?></h2>

                    <img src="/images/<?php echo $cutePet['filename']; ?>" class="img-rounded">

                    <blockquote class="pet-details">
                        <span class="label label-info"><?php echo $cutePet['breed']; ?></span>
                        <?php echo $cutePet['age']; ?>
                        <?php echo $cutePet['weight']; ?> lbs
                    </blockquote>

                    <p>
                        <?php echo $cutePet['bio']; ?>
                    </p>
                </div>
            <?php } ?>
        </div>

        <hr>

        <footer>
            <p>&copy; AirPupnMeow.com</p>
        </footer>
    </div>
    <!-- /container -->

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
