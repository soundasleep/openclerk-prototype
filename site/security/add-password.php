<?php

$user = Users\User::getInstance(db());
$result = Users\UserPassword::addPassword(db(), $user, "jevon");
if ($result) {
  echo "<h2>Added new password successfully</h2>";
} else {
  echo "<h2>Could not add password</a>";
}

echo link_to(url_for("index"), "Back home");
