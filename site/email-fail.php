<?php

require(__DIR__ . "/../inc/global.php");

$result = send_email("thisemailaddressshouldnotexist123123123123123123123@gmaiil.com", "test", array(
  "random" => rand(0,0x9999),
  "now" => date('r'),
  "site_url" => "http://localhost/",
));

echo "Sent an email " . print_r($result, true);

?>

<a href="index.php">Go home</a>
