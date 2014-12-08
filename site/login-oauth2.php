<?php

require(__DIR__ . "/../inc/global.php");

$user = Users\UserOAuth2::tryLogin(db(), Users\OAuth2Providers::google("http://localhost/openclerk2/login-oauth2.php"));
if ($user) {
  echo "<h2>Logged in successfully as $user</h2>";
  $user->persist(db());
} else {
  echo "<h2>Could not log in</a>";
}

?>

<a href="index.php">Back home</a>
