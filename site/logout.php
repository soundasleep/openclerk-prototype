<?php

require(__DIR__ . "/../inc/global.php");

$user = Users\User::logout(db());
echo "<h2>Logged out successfully</h2>";

?>

<a href="index.php">Back home</a>
