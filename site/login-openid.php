<?php

$user = Users\UserOpenID::tryLogin(db(), "http://www.jevon.org", absolute_url_for("security/login/openid"));
if ($user) {
  echo "<h2>Logged in successfully as $user</h2>";
  $user->persist(db());
} else {
  echo "<h2>Could not log in</a>";
}

echo link_to(url_for("index"), "Back home");
