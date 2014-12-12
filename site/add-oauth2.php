<?php

$user = Users\User::getInstance(db());
$result = Users\UserOAuth2::addIdentity(db(), $user, Users\OAuth2Providers::google(absolute_url_for("security/add/oauth2")));
if ($result) {
  echo "<h2>Added new identity successfully</h2>";
} else {
  echo "<h2>Could not add identity</a>";
}

echo link_to(url_for("index"), "Back home");
