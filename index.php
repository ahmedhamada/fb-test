<?php 
/*require_once __DIR__ . '/facebook/autoload.php'; // change path as needed

$fb = new \Facebook\Facebook([
  'app_id' => '{817858868393596}',
  'app_secret' => '{9e064077473efa4de495d4d98120a486}',
  'default_graph_version' => 'v2.10',
  //'default_access_token' => '{access-token}', // optional
]);*/
?>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1594163150877780',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.10'
    });
      
    FB.AppEvents.logPageView();   
      
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));




  // check if loged in
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
});
</script>