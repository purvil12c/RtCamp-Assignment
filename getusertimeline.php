<?php


    require "twitteroauth/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;

    session_start();
    $config = require_once 'config.php';

    $twitter = $_SESSION['twitter'];

    $q=$_GET["q"];

    $tweets = $twitter->get(
                "statuses/user_timeline", [
                    "count" => "10",
                    "screen_name" => $q
                ]
    );

    foreach ($tweets as $tweet) {
        echo "<li><h3 style='color:#000000'>".$tweet->text."</h3></li>";
    }

?>