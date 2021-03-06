<html>
<head>
    <title>RtCamp-Twitter-Challenge</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- bxSlider Javascript file -->
    <script src="lib/slider/jquery.bxslider.js"></script>
    <!-- bxSlider CSS file -->
    <link href="lib/slider/jquery.bxslider.css" rel="stylesheet" />
    <style>
        h1,h2,h3{
            color:#ffffff;
        }
    </style>
</head>
<body style="background-image: url('res/bg.jpg');
                   background-position: center;

      ">

    <div class = "container">

        <h1>
            Latest 10 tweets -
        </h1>
        <button class="btn btn-success" onclick="getTweets(this.value)">Get my tweets</button>
        <button class="btn btn-success" onclick="location.href='download.php'">Download Tweets in JSON (USER TIMELINE) RAW</button>
        <button class="btn btn-success" onclick="location.href='downloadonlytweets.php'">Download only Tweets in JSON (USER TIMELINE)</button>
        <button class="btn btn-success" onclick="location.href='downloadonlytweetscsv.php'">Download only Tweets in CSV (USER TIMELINE)</button>

        <hr>

    <?php


        require "lib/twitteroauth/autoload.php";
        use Abraham\TwitterOAuth\TwitterOAuth;

        session_start();
        $config = require_once 'config.php';

        $oauth_verifier = filter_input(INPUT_GET, 'oauth_verifier');

        if (empty($oauth_verifier) ||
            empty($_SESSION['oauth_token']) ||
            empty($_SESSION['oauth_token_secret'])
        ) {
            // something's missing, go and login again
            header('Location: ' . $config['url_login']);
        }

        // connect with application token
        $connection = new TwitterOAuth(
            $config['consumer_key'],
            $config['consumer_secret'],
            $_SESSION['oauth_token'],
            $_SESSION['oauth_token_secret']
        );

        // request user token
        $token = $connection->oauth(
            'oauth/access_token', [
                'oauth_verifier' => $oauth_verifier
            ]
        );

        $twitter = new TwitterOAuth(
            $config['consumer_key'],
            $config['consumer_secret'],
            $token['oauth_token'],
            $token['oauth_token_secret']
        );

        $_SESSION['token'] = $token;

        $twitter2 = new TwitterOAuth(
                    $config['consumer_key2'],
                    $config['consumer_secret2'],
                    $token['oauth_token'],
                    $token['oauth_token_secret']
        );

        $twitter3 = new TwitterOAuth(
                    $config['consumer_key3'],
                    $config['consumer_secret3'],
                    $token['oauth_token'],
                    $token['oauth_token_secret']
        );


        $_SESSION['twitter'] = $twitter;
        //$_SESSION['twitter2'] = $twitter2;
        //$_SESSION['twitter3'] = $twitter3;

        $tweets = $twitter->get(
            "statuses/home_timeline", [
                "count" => "10"
            ]
        );

        $usertweets = $twitter->get(
                    "statuses/user_timeline", [
                        "count" => "200"
                    ]
        );
        $_SESSION['usertweets']=$usertweets;

        $_SESSION['call_count']=1;

        echo "<ul class='bxslider' style='padding:10px;' id = 'slidershow'>";
        if (sizeof($tweets)==0){

                echo "<li style='margin-left:50px;margin-right:50px;'><h1 style='color:#000000'>No tweets from this user.</h1></li>";
        }
        else{
            foreach ($tweets as $tweet) {
                $user = $tweet->user;
                        $screenname = $user->screen_name;
                        echo "<li style= margin-left:50px;margin-right:50px;'><blockquote style='border-left: 5px solid #FFA500;'>
                                             <p>$tweet->text</p>
                                             <footer>$screenname</footer>
                                           </blockquote></li>";
            }
        }
        echo "</ul>";

        $followers = $twitter->get(
            "followers/list",[
                "count" => "10"
            ]
        );

        $_SESSION['call_count']+=1;

        $a=array();
        //array_push($a,"blue","yellow");

        $cursor = -1;
        $i = 0;
        do{
            $allfollowers = $twitter->get(
                                        "followers/list",[
                                         "count"=>"200",
                                         "cursor"=>$cursor,
                                        ]
            );
            $cursor = $allfollowers->next_cursor;
            //print_r($allfollowers);
            $allfollowers = $allfollowers->users;
            foreach ($allfollowers as $f) {
                         array_push($a, $f->screen_name);


             }
             //print_r($cursor);

            $_SESSION['call_count']+=1;

        }while($cursor!=0);



         $_SESSION['allfollowers']=$a;

        //echo $followers[0]->name;
        $followers = $followers->users;
         echo "<ul>";
         foreach ($followers as $f) {
             echo "<li>";
             echo "<h3>$f->screen_name</h3>";
             echo "</li>";

         }
         echo "</ul>";



    ?>


    <script>

        var slider = $('.bxslider').bxSlider();
        $(document).ready(function(){
          $('.bxslider').bxSlider();
          console.log("!@#");
        });


        function getResults(str){
            console.log(str);
            if (str.length==0) {
                document.getElementById("searchresults").innerHTML="";
                document.getElementById("searchresults").style.border="0px";
                return;
              }

              xmlhttp=new XMLHttpRequest();

              xmlhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                  document.getElementById("searchresults").innerHTML=this.responseText;
                  document.getElementById("searchresults").style.border="1px solid #A5ACB2";
                }
              }
              xmlhttp.open("GET","getfollowersresult.php?q="+str,true);
              xmlhttp.send();
        }

        function getTweets(str){

        console.log(str);
        xmlhttp=new XMLHttpRequest();

                      xmlhttp.onreadystatechange=function() {
                        if (this.readyState==4 && this.status==200) {
                          console.log("RESPONSE  - "+this.responseText);
                          document.getElementsByClassName('bxslider')[0].innerHTML =  this.responseText;
                          //console.log("Properties - "+slider.getOwnPropertyNames());
                          console.log("SLIDER - "+slider);
                          slider.reloadSlider();
                        }
                      }
                      xmlhttp.open("GET","getusertimeline.php?q="+str,true);
                      xmlhttp.send();


        }

        function getPublicSearchResults(str){
            console.log(str);
            if (str.length==0) {
                document.getElementById("publicresults").innerHTML="";
                document.getElementById("publicresults").style.border="0px";
                return;
              }

              xmlhttp=new XMLHttpRequest();

              xmlhttp.onreadystatechange=function() {
                if (this.readyState==4 && this.status==200) {
                  document.getElementById("publicresults").innerHTML=this.responseText;
                  document.getElementById("publicresults").style.border="1px solid #A5ACB2";
                }
              }
              xmlhttp.open("GET","publicsearch.php?q="+str,true);
              xmlhttp.send();
        }

    </script>
    <hr>
    <h3>Search your followers (Click on any of the listed users to fill the slider at the top with his/her tweets)</h3>
    <input type="text" placeholder="Search for followers" onkeyup="getResults(this.value)"></input>
    <div id="searchresults"></div>

    <h3>Search public accounts (Click on any of the listed users to download their tweets in PDF)</h3>
    <input type="text" placeholder="Search for public accounts" onkeyup="getPublicSearchResults(this.value)"></input>
    <div id="publicresults"></div>


    </div>


</body>
</html>