<?php

require(__DIR__ . "/../inc/global.php");

$user = Users\UserPassword::tryLogin(db(), "jevon@jevon.org", "jevon");
if ($user) {
  echo "<h2>Logged in successfully as $user</h2>";
  $user->persist(db());
} else {
  echo "<h2>Could not log in</a>";
}

?>

<a href="index.php">Back home</a>
