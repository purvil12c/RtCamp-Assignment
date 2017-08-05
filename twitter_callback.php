<html>
<head>
    <title>RtCamp-Twitter-Challenge</title>
    <link rel="stylesheet" href="./css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- bxSlider Javascript file -->
    <script src="jquery.bxslider.js"></script>
    <!-- bxSlider CSS file -->
    <link href="jquery.bxslider.css" rel="stylesheet" />

</head>
<body>

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


        $tweets = $twitter->get(
            "statuses/home_timeline", [
                "count" => "12"
            ]
        );
        echo "<ul class='bxslider'>";
        foreach ($tweets as $tweet) {
            echo "<li><h3>".$tweet->text."</h3></li>";
        }
        echo "</ul>";

        $followers = $twitter->get(
            "followers/list",[
                "count" => "10"
            ]
        );
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
        }

    </script>

    <input type="text" placeholder="Search for followers" onkeyup="getResults(this.value)"></input>
    <div id="searchresults"></div>

    </div>


</body>
</html>