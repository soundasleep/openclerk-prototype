<?php

require(__DIR__ . "/../inc/global.php");

$user = Users\User::findUser(db(), 1);
if (!$user) {
  throw new Exception("Could not find any user 1");
}
// or an email address

$result = send_email($user, "test", array(
  "random" => rand(0,0x9999),
  "now" => date('r'),
  "site_url" => "http://localhost/",
));

send_email("soundasleep@gmail.com", "test", array(
  "random" => rand(0,0x9999),
  "now" => date('r'),
  "site_url" => "http://localhost/",
));

echo "Sent an email $result to $user";

?>

<a href="index.php">Go home</a>
