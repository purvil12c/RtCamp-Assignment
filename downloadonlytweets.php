<?php

     require "twitteroauth/autoload.php";
     use Abraham\TwitterOAuth\TwitterOAuth;

     session_start();
     $config = require_once 'config.php';

     $usertweets = $_SESSION['usertweets'];

     $oauth_token = $_SESSION['oauth_token'];

     $mytweets = array();
     foreach ($usertweets as $tweet) {

        $myObj->tweet = $tweet->text;
        $myObj->tweetby = $tweet->user->screen_name;

        $temp = json_encode($myObj);
        array_push($mytweets,$temp);

     }

     $output="[";
     foreach ($mytweets as $tweet){
        $output+=$tweet;
     }
     $output+="]";

     //$myJSON = json_encode($mytweets);

     $fp = fopen('./mytweets/'.$oauth_token.'.json', 'w');
     file_put_contents('./mytweets/'.$oauth_token.'.json', $output);
     //fwrite($fp, json_encode($usertweets));


     header("Content-type: json");
     header("Content-Disposition: attachment;filename=mytweets_onlytweets.json");
     header("Content-Transfer-Encoding: binary");
     header('Pragma: no-cache');
     header('Expires: 0');

     readfile('./mytweets/'.$oauth_token.'.json');


?>