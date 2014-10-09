<?php
    include 'functions/functions.php';
    $helpers = new Helpers();
?>
<!doctype html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7">
<![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8">
<![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9">
<![endif]-->
<!--[if gt IE 8]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/ico" href="/assets/images/general/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php cms_head(); ?>

    <base href="http://<?= $_SERVER['HTTP_HOST'] ?>">
    <link href='http://fonts.googleapis.com/css?family=Nobile:400,700' rel='stylesheet' type='text/css'>


    <link rel="stylesheet" href="/assets/css/stylesheets/app.css">
    <?php /*
    <link rel="stylesheet" href="assets/css/stylesheets/production.min.css">
    */ ?>

    <?php /*
    <script src="/assets/js/modernizr.custom.04582.js"></script>
    <script src="/assets/js/placeholder_polyfill.jquery.js"></script>
    <script src="/assets/js/app.js"></script>
    */ ?>
    <script src="/assets/js/production.min.js"></script>
    

    <!--[if lt IE 9]>
        <script src="/assets/js/html5shiv.min.js"></script>
        <link rel="stylesheet" href="/assets/css/stylesheets/ie8.css">
    <![endif]-->
    <!--[if lt IE 8]>
        <link rel="stylesheet" href="/assets/css/stylesheets/ie7.css">
    <![endif]-->
    <!--[if lt IE 9]>
        <script src="/assets/js/response.js"></script>
    <![endif]-->

    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-20884637-3']);
        _gaq.push(['_trackPageview']);
        
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>
</head>
<body class="<?= $helpers->is_page('/', 'home') ?>">
<div class="site-wrapper">
    <div class="mob-home-wrapper">
        <header class="container main-header">
            <a href="/" class="logo">
                <img src="/assets/images/general/primal-logo.png" alt="Primal Surfacing Logo">
            </a>
            <a id="mob-menu-toggle" href="#" class="mob-nav-toggle <?= $helpers->is_not_page('/', 'inner-header') ?>">
                <span class="icon icon-menu">&#xe602;</span>
            </a>

            <nav id="mob-menu" class="main-nav <?= $helpers->is_not_page('/', 'inner-header') ?>">
                <ul class="links">
                    <li class="<?= $helpers->is_page('/') ?>"><a href="/"><span>HOME</span></a></li>
                    <li class="<?= $helpers->is_page('about') ?>"><a href="/about/"><span>ABOUT</span></a></li>
                    <li class="<?= $helpers->is_page('process') ?>"><a href="/process/"><span>PROCESS</span></a></li>
                    <li class="<?= $helpers->is_page('solutions') ?>"><a href="/solutions/"><span>SOLUTION</span></a></li>
                    <li class="<?= $helpers->is_page('clients') ?>"><a href="/clients/"><span>CLIENTS</span></a></li>
                    <li class="<?= $helpers->is_page('contact') ?>"><a href="/contact/"><span>CONTACT</span></a></li>
                    <li class="tel-nav"><a href="tel:+0399932993" class="phone">Ph: (03)9369 9931</a></li>
                </ul>
            </nav>
            <div><a href="tel:+0399932993" class="tel">Ph: (03)9369 9931</a></div>
        </header>
    </div>