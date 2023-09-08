<?php
session_start();

require_once 'twitteroauth/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

// Your Twitter API credentials
$api_key = 'YOUR_API_KEY';
$api_secret_key = 'YOUR_API_SECRET_KEY';
$access_token = 'YOUR_ACCESS_TOKEN';
$access_token_secret = 'YOUR_ACCESS_TOKEN_SECRET';

// Create a new TwitterOAuth instance
$connection = new TwitterOAuth($api_key, $api_secret_key, $access_token, $access_token_secret);

// Get the temporary credentials
$request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => 'YOUR_CALLBACK_URL'));

// Save the temporary credentials to session
$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

// Generate the authorization URL
$url = $connection->url('oauth/authenticate', array('oauth_token' => $request_token['oauth_token']));

// Return the redirect URL to the JavaScript code
echo json_encode(array('redirect_url' => $url));
?>