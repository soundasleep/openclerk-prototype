<?php

$user = Users\UserOpenID::trySignup(db(), null /* no email */, "http://www.jevon.org", absolute_url_for("security/register/openid"));
if ($user) {
  echo "<h2>Signed up successfully</h2>";
} else {
  echo "<h2>Could not sign up</a>";
}

echo link_to(url_for("index"), "Back home");
