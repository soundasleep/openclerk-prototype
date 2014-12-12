<?php

require(__DIR__ . "/../inc/global.php");

// generate secret
$secret = require_get("secret");
$email = "jevon@jevon.org";

Users\UserPassword::completePasswordReset(db(), $email, $secret, "jevon");

?>

<a href="index.php">Back home</a>
