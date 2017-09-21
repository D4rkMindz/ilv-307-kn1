<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#222222">
    <meta name="author" content="Bjoern Pfoster">
    <meta name="description" content="A proper Contactform :D">
    <meta name="keywords" content="Contact, contactform, d4rkmidnz">
    <meta name=“robots” content=“nofollow”>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <base href="<?php echo baseurl("/", true) ?>">
    <link rel="canonical" href="https://contactform.d4rkmindz.ch/"/>
    <link rel="icon" href="favicon.ico">


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <script type='text/javascript' src='js/notifIt.min.js'></script>
    <script src="js/script.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/mustache.min.js"></script>


    <?php foreach ($this->next("js") as $path) : ?>
        <script type="text/javascript" src="<?= $path ?>"></script>
    <?php endforeach; ?>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel='stylesheet' type='text/css' href='css/notifIt.css'>
    <link rel="stylesheet" href="css/style.css">

    <?= $this->section('assets') ?>

    <title><?= $this->wh("page") ?></title>

</head>
<?php
$query = request()->server->get('REQUEST_URI');
$pathinfo = pathinfo($query);
$base = $pathinfo['basename'];
?>
<body>
<nav class="navbar navbar-inverse container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only"><?= $this->e(__("Toggle navigation")) ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo baseurl("/") ?>"><?= $this->e(__("Home")) ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown" data-script-identifier="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false"><?= $this->e(__("Language")) ?><span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo baseurl("/language") . '?lang=de_DE' ?>">Deutsch</a></li>
                        <li><a href="<?php echo baseurl("/language") . '?lang=en_US' ?>">English</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="section-content"></div>
<?= $this->section('content') ?>
<?= asset('view::Layout/layout.css') ?>
<div id="loader">
    <div id="loading"></div>
</div>
</body>
</html>
