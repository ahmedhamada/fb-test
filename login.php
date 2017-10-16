<?php
session_start();
require_once __DIR__ . '/Facebook/autoload.php';
 
$fb = new Facebook\Facebook([
  'app_id' => '1695277584089621',
  'app_secret' => '6c6c982391f0bb76b482e700abd2a516',
  'default_graph_version' => 'v2.5',
  ]);
 
$helper = $fb->getRedirectLoginHelper();
 
$permissions = ['email,user_about_me,user_posts']; // optional
     


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
        echo "nummber of posts you created is: " . count($profile['posts']) . '<br>'; 
        echo "nummber of posts you created is: " . count($profile[1]). '<br>'; 
        echo "nummber of posts you created is: " . count($profile[2]). '<br>'; 
        echo "nummber of posts you created is: " . count($profile[3]). '<br>'; 
        echo "nummber of posts you created is: " . count($profile[0][0]). '<br>'; 
        echo "nummber of posts you created is: " . count($profile[0][1]). '<br>'; 
        echo "nummber of posts you created is: " . count($profile[0][2]). '<br>'; 
        echo "nummber of posts you created is: " . count($profile[0][3]). '<br>'; 
        echo "nummber of posts you created is: " . count($profile[1][0]). '<br>'; 
        echo "nummber of posts you created is: " . count($profile[1][1]). '<br>'; 
        echo "nummber of posts you created is: " . count($profile[1][2]). '<br>'; 
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
    print_r($profile);
 
    // Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
    // replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
    $loginUrl = $helper->getLoginUrl('https://just-it.herokuapp.com/login.php', $permissions);
    echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}






?>
<style type="text/css">
    background: #101012 url(images/chalkboard.jpg) no-repeat top center;
    background-size: cover;
    background-attachment: fixed;
    height: 100%;
</style>