Identifing Your Users
=============================
This code shows how to grab an OAuth2 authenticated user's userinfo for a Google+ account.
The profile information that comes back will include a name, user id, profile picture, and google+ url.

It is intended as a complement to my tutorial:
http://20missionglass.tumblr.com/post/67015356413/identifing-your-users

Configuration
--------------
Set up an OAuth2 Client App in the Google Code Console:
https://cloud.google.com/console

Once you register an app, you will get a client id and client secret.  

Edit your settings.php to reflect your oauth2 client app's settings.

$settings['oauth2']['oauth2_client_id'] = 'YOURCLIENTID.apps.googleusercontent.com';
$settings['oauth2']['oauth2_secret'] = 'YOURCLIENTSECRET';
$settings['oauth2']['oauth2_redirect'] = 'https://example.com/oauth2callback';



Now you should be good to go.


