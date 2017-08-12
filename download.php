<?php

     require "twitteroauth/autoload.php";
     use Abraham\TwitterOAuth\TwitterOAuth;

     session_start();
     $config = require_once 'config.php';

     $usertweets = $_SESSION['usertweets'];

     //$fp = fopen('mytweets.json', 'w');
     file_put_contents('mytweets.json', json_encode($usertweets));
     //fwrite($fp, json_encode($usertweets));


     header("Content-type: json");
     header("Content-Disposition: attachment;filename=mytweets.json");
     header("Content-Transfer-Encoding: binary");
     header('Pragma: no-cache');
     header('Expires: 0');

     readfile('mytweets.json');


?>