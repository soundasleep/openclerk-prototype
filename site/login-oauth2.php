<?php

$user = Users\UserOAuth2::tryLogin(db(), Users\OAuth2Providers::google(absolute_url_for("security/login/oauth2")));
if ($user) {
  echo "<h2>Logged in successfully as $user</h2>";
  $user->persist(db());
} else {
  echo "<h2>Could not log in</a>";
}

echo link_to(url_for("index"), "Back home");

?>
