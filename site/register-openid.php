<?php

require(__DIR__ . "/../inc/global.php");

$user = Users\UserOpenID::trySignup(db(), null /* no email */, "http://www.jevon.org", "http://localhost/openclerk2/register-openid.php");
if ($user) {
  echo "<h2>Signed up successfully</h2>";
} else {
  echo "<h2>Could not sign up</a>";
}

?>

<a href="index.php">Back home</a>
