<?php
include_once("inc/facebook.php"); //include facebook SDK
######### Facebook API Configuration ##########
$appId = '473052766218131'; //Facebook App ID
$appSecret = 'c6564f05268c94b9a86ff23897032552'; // Facebook App Secret
$homeurl = 'http://localhost/optical/';  //return to home
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret

));
$fbuser = $facebook->getUser();
?>