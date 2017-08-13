<?php


    require "lib/twitteroauth/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;

    session_start();
    $config = require_once 'config.php';

    $twitter = $_SESSION['twitter'];

    $q=$_GET["q"];

    if($_SESSION['call_count']>=12){
        echo "<script>alert('Retry Later! API LIMIT REACHED');";
    }
    else{
        $tweets = $twitter->get(
                    "statuses/user_timeline", [
                        "count" => "10",
                        "screen_name" => $q
                    ]
        );
        //print_r($tweets);
    }
    foreach ($tweets as $tweet) {
        $user = $tweet->user;
        $screenname = $user->screen_name;
        echo "<li style='margin-left:50px;margin-right:50px;'><blockquote>
                             <p>$tweet->text</p>
                             <footer>$screenname</footer>
                           </blockquote></li>";
    }

?>