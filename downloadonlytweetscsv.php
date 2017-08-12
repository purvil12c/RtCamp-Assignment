<?php

     require "twitteroauth/autoload.php";
     use Abraham\TwitterOAuth\TwitterOAuth;

     session_start();
     $config = require_once 'config.php';

     $usertweets = $_SESSION['usertweets'];

     $oauth_token = $_SESSION['oauth_token'];

     $mytweets = array();
     foreach ($usertweets as $tweet) {

        $myObj=array(
                "tweet" => $tweet->text,
                "user" => $tweet->user->screen_name
            );

        array_push($mytweets,$myObj);

     }

     //$myJSON = json_encode($mytweets);

     $fp = fopen('./mytweets/'.$oauth_token.'.csv', 'w');
     fputcsv('./mytweets/'.$oauth_token.'.csv', $mytweets);
     //fwrite($fp, json_encode($usertweets));


     header("Content-type: json");
     header("Content-Disposition: attachment;filename=mytweets_onlytweets.csv");
     header("Content-Transfer-Encoding: binary");
     header('Pragma: no-cache');
     header('Expires: 0');

     readfile('./mytweets/'.$oauth_token.'.csv');


?>