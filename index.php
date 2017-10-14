<?php 
/*require_once __DIR__ . '/facebook/autoload.php'; // change path as needed

$fb = new \Facebook\Facebook([
  'app_id' => '{817858868393596}',
  'app_secret' => '{9e064077473efa4de495d4d98120a486}',
  'default_graph_version' => 'v2.10',
  //'default_access_token' => '{access-token}', // optional
]);*/
?>




<div id="status"></div>
<script>
    // This is called with the results from from FB.getLoginStatus().
    function statusChangeCallback(response) {
        console.log('statusChangeCallback');
        console.log(response);
        // The response object is returned with a status field that lets the app know the current login status of the person.
        // Full docs on the response object can be found in the documentation for FB.getLoginStatus().
        if (response.status === 'connected') {
            // Logged into your app and Facebook.
            testAPI();
        } else if (response.status === 'not_authorized') {
            testAPI();
            // The person is logged into Facebook, but not your app.
            document.getElementById('status').innerHTML = 'Please log ' + 'into this app.';
        } else {
            // The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
            document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook.';
        }
    }

    // This is called with the results from from FB.getLoginStatus().
    function myFBLogin() {
        FB.login(function (response) {
            console.log('statusChangeCallback');
            console.log(response);
            // The response object is returned with a status field that lets the app know the current login status of the person.
            // Full docs on the response object can be found in the documentation for FB.getLoginStatus().
            if (response.status === 'connected') {
                // Logged into your app and Facebook.
                testAPI();
                console.log('it is connected ');
            } else if (response.status === 'not_authorized') {
              console.log('it is not authorized ');
                // The person is logged into Facebook, but not your app.
                document.getElementById('status').innerHTML = 'Please log ' + 'into this app.';
            } else {
                // The person is not logged into Facebook, so we're not sure if they are logged into this app or not.
                document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook.';
            }
        });
    }

    // This function is called when someone finishes with the Login Button.
    // See the onlogin handler attached to it in the sample code below.
    function checkLoginState() {
        FB.getLoginStatus(function (response) {
            statusChangeCallback(response);
            console.log(response);
        });
    }

    window.fbAsyncInit = function () {
        FB.init({
            appId   : '1695277584089621',
            xfbml   : true,
            version : 'v2.6'
        });

        // Now that we've initialized the JavaScript SDK, we call FB.getLoginStatus().
        // This function gets the state of theperson visiting this page and can return 1 of 3 states to callback you provide:
        //   1. Logged into your app ('connected')
        //   2. Logged into Facebook, but not your app ('not_authorized')
        //   3. Not logged into Facebook and can't tell if they are logged into your app or not.
        // These three cases are handled in the callback function.

        FB.getLoginStatus(function (response) {
            statusChangeCallback(response);
        });
    };

    (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    // Here we run a very simple test of the Graph API after login is
    // successful.  See statusChangeCallback() for when this call is made.
    function testAPI() {
        console.log('Welcome! Fetching your information.... ');
        FB.api('/me', function (response) {
            console.log('Successful login for: ' + response);
            document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response.name + '!';
        });
    }

</script>