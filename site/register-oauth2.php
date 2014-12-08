<?php

require(__DIR__ . "/../inc/global.php");

$user = Users\UserOAuth2::trySignup(db(), Users\OAuth2Providers::google("http://localhost/openclerk2/register-oauth2.php"));
if ($user) {
  echo "<h2>Signed up successfully</h2>";
} else {
  echo "<h2>Could not sign up</a>";
}

?>

<a href="index.php">Back home</a>
