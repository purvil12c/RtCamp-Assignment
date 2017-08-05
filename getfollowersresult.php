<?php


    require "twitteroauth/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;

    session_start();
    $config = require_once 'config.php';

    $twitter = $_SESSION['twitter'];

    $q=$_GET["q"];

    $allfollowers = $_SESSION['allfollowers'];

    $allfollowers = $allfollowers->users;
    echo "<ul>";
    foreach ($allfollowers as $f) {
        if(stristr($f->screen_name, $q)){
            echo "<li>";
            echo "<h3>$f->screen_name</h3>";
            echo "</li>";
        }
     }
     echo "</ul>";



?>