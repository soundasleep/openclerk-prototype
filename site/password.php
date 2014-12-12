<?php

require(__DIR__ . "/../inc/global.php");

// generate secret
$email = "jevon@jevon.org";
$user = Users\UserPassword::getPasswordUser(db(), $email);
$user = Users\User::findUser(db(), $user['id']);
$secret = Users\UserPassword::forgottenPassword(db(), $email);

// send forgotten password email
$result = send_email($user, "forgot_password", array(
  "secret" => $secret,
  "email" => $email,
  "expires" => \Openclerk\Config::get('user_password_reset_expiry'),
  "site_url" => "http://localhost/",
));

// quick hack
echo "<a href=\"password-reset.php?secret=" . urlencode($secret) . "\">complete reset</a>";

?>

<a href="index.php">Back home</a>
