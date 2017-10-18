<?php
session_start();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<title>how many post you create in facebook </title>

<meta property="og:url"          content="https://just-it.herokuapp.com/" />
<meta property="og:title"        content="how many post you created in facebook" />
<meta property="og:type"         content="website" />  
<meta property="og:image"        content="https://just-it.herokuapp.com/what.png" />
<meta property="og:image:type"   content="image/jpeg" />
<meta property="og:image:width"  content="100" />
<meta property="og:image:height" content="100" />
<meta property="og:description"  content="by ahmed hamada" />

<script type="text/javascript">
$(document).ready(function(){
    $('a').click(function(){
        $('center').fadeOut(3000);
        $('h2').hide(1000);

    })
});


   // jQuery methods go here...

</script>


<body>
<div class="container">
    <?php if (isset($_SESSION['facebook_access_token'])): ?>
        <center> the number is  </center>
    <?php else: ?>
        <h2 style="text-align: center;">know the number of posts you create on facebook</h2>
    <?php endif ?>





<?php
require_once __DIR__ . '/Facebook/autoload.php';
 
$fb = new Facebook\Facebook([
  'app_id' => '1695277584089621',
  'app_secret' => '6c6c982391f0bb76b482e700abd2a516',
  'default_graph_version' => 'v2.5',
  'cookies' => true
  ]);
 
$helper = $fb->getRedirectLoginHelper();
 
// $permissions = ['email,user_about_me,user_posts,public_profile,user_friends']; // optional
$permissions =  array(
     scope => 'read_stream,publish_stream,publish_actions,read_friendlists',
     redirect_uri => 'https://just-it.herokuapp.com/login.php'
  );


// no need for explain
try {
    if (isset($_SESSION['facebook_access_token'])) {
        $accessToken = $_SESSION['facebook_access_token'];
    } else {
        $accessToken = $helper->getAccessToken();
    }
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
 
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
 }



 
if (isset($accessToken)) {
    if (isset($_SESSION['facebook_access_token'])) {
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    } else {
        // getting short-lived access token
        $_SESSION['facebook_access_token'] = (string) $accessToken;
 
        // OAuth 2.0 client handler
        $oAuth2Client = $fb->getOAuth2Client();
 
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
 
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
 
        // setting default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
 
    // redirect the user back to the same page if it has "code" GET variable
    if (isset($_GET['code'])) {
        header('Location: ./');
    }
 
    // getting basic info about user
    try {/*me?fields=posts.limit(555){id}*/
        // $profile_request = $fb->get('/me?fields=posts.limit(555){permalink_url}');
        $profile_request = $fb->get('/me?fields=posts.limit(239){id}');
        $profile = $profile_request->getGraphNode()->asArray();
        
      echo '<center> <h1 class="gold"> '.$posts_count = count($profile['posts']) . ' posts<h1></center><br>'; 

    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();
        // redirecting user back to app login page
        header("Location: ./");
        exit;
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
     
    // printing $profile array on the screen which holds the basic info about user
    // all return info
    // print_r($profile);
 
    // Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
    // replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
    $loginUrl = $helper->getLoginUrl($permissions);
    // $loginUrl = $helper->getLoginUrl('https://just-it.herokuapp.com/login.php', $permissions);
    echo '<center><a href="' . $loginUrl . '">Log in with Facebook!</a><center>';
}



?>




</div><!-- end container -->
</body>








<style type="text/css">
body{
    background: #101012 url(chalkboard.jpg) no-repeat top center;
    background-size: cover;
    background-attachment: fixed;
    height: 100%;
}
.container{
    width: 600px;
    margin: 0 auto;
    background-color: white;
    border-radius: 15px;
}
.gold{
    color: gold;
}
</style>

