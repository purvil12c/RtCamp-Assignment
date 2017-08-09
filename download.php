<?php

     require "twitteroauth/autoload.php";
     use Abraham\TwitterOAuth\TwitterOAuth;

     session_start();
     $config = require_once 'config.php';

     $usertweets = $_SESSION['usertweets'];

     $fp = fopen('{$token['oauth_token']}.json', 'w');
     fwrite($fp, json_encode($usertweets));
     fclose($fp);

     header("Content-type: $type");
     header("Content-Disposition: attachment;filename={$token['oauth_token']}.txt");
     header("Content-Transfer-Encoding: binary");
     header('Pragma: no-cache');
     header('Expires: 0');

     set_time_limit(0);
     readfile($file);


?>