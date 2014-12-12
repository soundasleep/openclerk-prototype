<?php

$user = Users\User::getInstance(db());
$result = Users\UserOpenID::addIdentity(db(), $user, "http://www.jevon.org", absolute_url_for("security/add/openid"));
if ($result) {
  echo "<h2>Added new identity successfully</h2>";
} else {
  echo "<h2>Could not add identity</a>";
}

echo link_to(url_for("index"), "Back home");
