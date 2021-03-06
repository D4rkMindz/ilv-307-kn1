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
    <link rel="icon" href="favicon.ico">


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <script src="js/notifIt.min.js"></script>
    <script src="js/script.js"></script>


    <?php foreach ($this->next("js") as $path) : ?>
        <script type="text/javascript" src="<?= $path ?>"></script>
    <?php endforeach; ?>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/notifIt.css">

    <?= $this->section('assets') ?>


    <title>Müller's Hofladen - <?= $this->v('abbr') ?></title>
    <!-- modernizr enables HTML5 elements and feature detects -->
    <script type="text/javascript" src="js/modernizr-1.5.min.js"></script>

</head>
<?php
$query = request()->server->get('REQUEST_URI');
$pathinfo = pathinfo($query);
$base = $pathinfo['basename'];
?>
<body>
<div id="main">
    <header>
        <div id="logo">
            <div id="logo_text">
                <!-- class="logo_colour", allows you to change the colour of the text -->
                <h1><a href="<?= baseurl('/') ?>">m&uuml;ller&apos;s<span class="logo_colour">_hofladen</span></a></h1>
                <h2>Natürliche Produkte, direkt ab Hof!</h2>
            </div>
        </div>
        <nav>
            <ul class="sf-menu" id="nav">
                <li<?php if ($base == "template") {
                    print(' class="selected"');
                } ?>><a href="<?= baseurl('/') ?>">Home</a></li>
                <li<?php if ($base == "produkte") {
                    print(' class="selected"');
                } ?>><a href="<?= baseurl('/produkte') ?>">Unsere Produkte</a>
                    <ul>
                        <li<?php if ($base == "produkte/fleisch") {
                            print(' class="selected"');
                        } ?>><a href="<?= baseurl('/produkte/fleisch') ?>">Fleischliche Produkte</a>
                            <ul>
                                <li<?php if ($base == "produkte/fleisch/rind") {
                                    print(' class="selected"');
                                } ?>><a href="<?= baseurl('/produkte/fleisch/rind') ?>">Rind</a></li>
                                <li<?php if ($base == "produkte/fleisch/kaninchen") {
                                    print(' class="selected"');
                                } ?>><a href="<?= baseurl('/produkte/fleisch/kaninchen') ?>">Kaninchen</a></li>
                            </ul>
                        </li>
                        <li<?php if ($base == "produkte/pflanzlich") {
                            print(' class="selected"');
                        } ?>><a href="<?= baseurl('/produkte/pflanzlich') ?>">Pflanzliche Produkte</a></li>
                    </ul>
                </li>
                <li<?php if ($base == "öffnungszeiten") {
                    print(' class="selected"');
                } ?>><a href="<?= baseurl('/öffnungszeiten') ?>">Öffnungszeiten</a></li>
                <li<?php if ($base == "kontakt") {
                    print(' class="selected"');
                } ?>><a href="<?= baseurl('/kontakt') ?>">Kontakt</a></li>
                <li<?php if ($base == "wetter") {
                    print(' class="selected"');
                } ?>><a href="<?= baseurl('/wetter') ?>">Wetter</a></li>
                <li<?php if ($base == "warenkorb") {
                    print(' class="selected"');
                } ?>><a href="<?= baseurl('/warenkorb') ?>">Warebkorb (<?= $this->v('count'); ?>) </a></li>
            </ul>
        </nav>
    </header>
    <div id="site_content">
        <div class="gallery">
            <ul class="images">
                <li class="show"><img width="950" height="300" src="images/1.jpg" alt="photo_one"/></li>
                <li><img width="950" height="300" src="images/2.jpg" alt="seascape"/></li>
                <li><img width="950" height="300" src="images/3.jpg" alt="seascape"/></li>
            </ul>
        </div>
        <?php if ($this->v('news')): ?>
            <div id="sidebar_container">
                <div class="sidebar">
                    <h3>News</h3>

                    <h4>Neue Öffnungszeiten</h4>
                    <h5>15.08.2016</h5>
                    <p>Wir haben neue Öffnungszeiten. Bitte beachten!<br/><a href="<?= baseurl('/öffnungszeiten') ?>">Zu
                            den Öffnungszeiten</a></p>

                    <h4>Rindfleisch - Letzte Chance!</h4>
                    <h5>15.07.2016</h5>
                    <p>Wir haben nur noch wenige 10-Kilo Pakete Rindfleisch!<br/><a
                                href="<?= baseurl('/produkte/fleisch/rind') ?>">Jetzt zuschlagen!</a></p>
                </div>
            </div>
        <?php endif; ?>
        <div class="content">
            <h1><?= $this->v('title') ?></h1>
            <?= $this->section('content') ?>
        </div>
    </div>
    <footer>
        <p>Müller's Hofladen | Bauernhofstrasse 10 | 1234 Bauernhausen</p>
    </footer>
</div>
<p>&nbsp;</p>
<!-- javascript at the bottom for fast page loading -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.easing-sooper.js"></script>
<script type="text/javascript" src="js/jquery.sooperfish.js"></script>
<script type="text/javascript" src="js/image_fade.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('ul.sf-menu').sooperfish();
    });
</script>
</body>
</html>

<div id="loader">
    <div id="loading"></div>
</div>
</body>
</html>
