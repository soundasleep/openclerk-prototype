<?php

require(__DIR__ . "/../inc/global.php");

$user = Users\User::getInstance(db());
$result = Users\UserOAuth2::addIdentity(db(), $user, Users\OAuth2Providers::google("http://localhost/openclerk2/add-oauth2.php"));
if ($result) {
  echo "<h2>Added new identity successfully</h2>";
} else {
  echo "<h2>Could not add identity</a>";
}

?>

<a href="index.php">Back home</a>
