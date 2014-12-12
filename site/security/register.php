<?php

$user = Users\UserPassword::trySignup(db(), "jevon@jevon.org", "jevon");
if ($user) {
  echo "<h2>Signed up successfully</h2>";
} else {
  echo "<h2>Could not sign up</a>";
}

echo link_to(url_for("index"), "Back home");
