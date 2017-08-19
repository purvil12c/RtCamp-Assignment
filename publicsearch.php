<?php


    require "lib/twitteroauth/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;

    session_start();
    $config = require_once 'config.php';

    $twitter = $_SESSION['twitter'];

    $q=$_GET["q"];

    $searchresults =  $twitter->get(
     "users/search", [
    "count" => "5",
    "q" =>$q,
    ]
    );


    echo "<ul>";
    foreach ($searchresults as $f) {
        {
            echo "<li>";
            echo "<h3 onclick='getTweets(this.innerHTML)'>$f->screen_name</h3>";
            echo "</li>";
        }
     }
     echo "</ul>";



?>