<?php

     require "twitteroauth/autoload.php";
     use Abraham\TwitterOAuth\TwitterOAuth;

     session_start();
     $config = require_once 'config.php';

     $usertweets = $_SESSION['usertweets'];

     $oauth_token = $_SESSION['oauth_token'];

     $mytweets = array();
     foreach ($usertweets as $tweet) {
        array_push($mytweets,$tweet->text);

     }

     $myJSON = json_encode($mytweets);

     $fp = fopen('./mytweets/'.$oauth_token.'.json', 'w');
     file_put_contents('./mytweets/'.$oauth_token.'.json', $myJSON);
     //fwrite($fp, json_encode($usertweets));


     header("Content-type: json");
     header("Content-Disposition: attachment;filename=mytweets_raw.json");
     header("Content-Transfer-Encoding: binary");
     header('Pragma: no-cache');
     header('Expires: 0');

     readfile('./mytweets/'.$oauth_token.'.json');


?>