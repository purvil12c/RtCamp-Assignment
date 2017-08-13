<?php

     require "lib/twitteroauth/autoload.php";
     use Abraham\TwitterOAuth\TwitterOAuth;

     session_start();
     $config = require_once 'config.php';

     $usertweets = $_SESSION['usertweets'];

     $oauth_token = $_SESSION['oauth_token'];

     $fp = fopen('./mytweets/'.$oauth_token.'.csv', 'w');
     $mytweets = array();
     foreach ($usertweets as $tweet) {

        array_push($mytweets,"".$tweet->text.",".$tweet->user->screen_name);

     }


     foreach ($mytweets as $line)
     {
       fputcsv($fp,explode(',',$line));
     }


     header("Content-type: json");
     header("Content-Disposition: attachment;filename=mytweets_onlytweets.csv");
     header("Content-Transfer-Encoding: binary");
     header('Pragma: no-cache');
     header('Expires: 0');

     readfile('./mytweets/'.$oauth_token.'.csv');


?>