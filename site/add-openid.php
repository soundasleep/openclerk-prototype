<?php

require(__DIR__ . "/../inc/global.php");

$user = Users\User::getInstance(db());
$result = Users\UserOpenID::addIdentity(db(), $user, "http://www.jevon.org", "http://localhost/openclerk2/add-openid.php");
if ($result) {
  echo "<h2>Added new identity successfully</h2>";
} else {
  echo "<h2>Could not add identity</a>";
}

?>

<a href="index.php">Back home</a>
