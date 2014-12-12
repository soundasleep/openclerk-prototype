<?php

$user = Users\UserOAuth2::trySignup(db(), Users\OAuth2Providers::google(absolute_url_for("security/register/oauth2")));
if ($user) {
  echo "<h2>Signed up successfully</h2>";
} else {
  echo "<h2>Could not sign up</a>";
}

echo link_to(url_for("index"), "Back home");
