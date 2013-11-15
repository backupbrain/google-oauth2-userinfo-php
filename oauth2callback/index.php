<?php
// oauth2callback/index.php


require('../settings.php');

require_once('../classes/Google_OAuth2_Token.class.php');
require_once('../classes/Google_Userinfo.class.php');

/**
 * the OAuth server should have brought us to this page with a $_GET['code']
 */
if(isset($_GET['code'])) {
    // try to get an access token
    $code = $_GET['code'];
 
	// authenticate the user
	$Google_OAuth2_Token = new Google_OAuth2_Token();
	$Google_OAuth2_Token->code = $code;
	$Google_OAuth2_Token->client_id = $settings['oauth2']['oauth2_client_id'];
	$Google_OAuth2_Token->client_secret = $settings['oauth2']['oauth2_secret'];
	$Google_OAuth2_Token->redirect_uri = $settings['oauth2']['oauth2_redirect'];
	$Google_OAuth2_Token->grant_type = "authorization_code";

	try {
		$Google_OAuth2_Token->authenticate();
	} catch (Exception $e) {
		// handle this exception
		print_r($e);
	}

	// now let's post some HTML to the timeline!
	if ($Google_OAuth2_Token->authenticated) {
		
		// grab the user's information
		$Google_Userinfo = new Google_Userinfo($Google_OAuth2_Token);
		
		try {
			$Google_Userinfo->fetch();
		} catch (Exception $e) {
			// handle this exception
			print_r($e);
		}
		
		
	}
}

?>
<h1>You Have Logged In</h1>
<dl>
	<dt>Name:</dt>
	<dd><?= $Google_Userinfo->name; ?></dd>
	<dt>user id:</dt>
	<dd><?= $Google_Userinfo->id; ?></dd>
	<dt>Google+ URL:</dt>
	<dd><?= $Google_Userinfo->link; ?></dd>
</dl>