<?php


    require "twitteroauth/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;

    session_start();
    $config = require_once 'config.php';

    $twitter = $_SESSION['twitter'];

    $q=$_GET["q"];

    $allfollowers = $_SESSION['allfollowers'];


    echo "<ul>";
    foreach ($allfollowers as $f) {
        if(stristr($f, $q)){
            echo "<li>";
            echo "<h3 onclick='getTweets(this.innerHTML)'>$f</h3>";
            echo "</li>";
        }
     }
     echo "</ul>";



?>