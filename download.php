<?php

     require "twitteroauth/autoload.php";
     use Abraham\TwitterOAuth\TwitterOAuth;

     session_start();
     $config = require_once 'config.php';

     $usertweets = $_SESSION['usertweets'];

     $fp = fopen('mytweets.json', 'w');
     fwrite($fp, json_encode($usertweets));


     header("Content-type: $type");
     header("Content-Disposition: attachment;filename=mytweets.json");
     header("Content-Transfer-Encoding: binary");
     header('Pragma: no-cache');
     header('Expires: 0');

     set_time_limit(0);
     readfile($fp);


?>