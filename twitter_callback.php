<html>
<head>
    <title>RtCamp-Twitter-Challenge</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- bxSlider Javascript file -->
    <script src="jquery.bxslider.js"></script>
    <!-- bxSlider CSS file -->
    <link href="jquery.bxslider.css" rel="stylesheet" />
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
        <hr>

    <?php


        require "twitteroauth/autoload.php";
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

        $_SESSION['twitter'] = $twitter;

        $tweets = $twitter->get(
            "statuses/home_timeline", [
                "count" => "10"
            ]
        );
        echo "<ul class='bxslider'>";
        foreach ($tweets as $tweet) {
            echo "<li><h3 style='color:#000000'>".$tweet->text."</h3></li>";
        }
        echo "</ul>";

        $followers = $twitter->get(
            "followers/list",[
                "count" => "10"
            ]
        );

        $allfollowers = $twitter->get(
                                    "followers/list",[

                                    ]
                                );

         $_SESSION['allfollowers']=$allfollowers;

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

    </script>
    <hr>
    <h3>Search your followers</h3>
    <input type="text" placeholder="Search for followers" onkeyup="getResults(this.value)"></input>
    <div id="searchresults"></div>

    </div>


</body>
</html>