<?php

     require "twitteroauth/autoload.php";
     use Abraham\TwitterOAuth\TwitterOAuth;

     session_start();
     $config = require_once 'config.php';

     $usertweets = $_SESSION['usertweets'];

     $oauth_token = $_SESSION['oauth_token'];


     $fp = fopen($oauth_token.'.json', 'w');
     file_put_contents($oauth_token.'.json', json_encode($usertweets));
     //fwrite($fp, json_encode($usertweets));


     header("Content-type: json");
     header("Content-Disposition: attachment;filename=mytweets.json");
     header("Content-Transfer-Encoding: binary");
     header('Pragma: no-cache');
     header('Expires: 0');

     readfile($oauth_token.'.json');


?>