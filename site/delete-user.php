<?php

require(__DIR__ . "/../inc/global.php");

$user = Users\User::getInstance(db());
$user->delete(db());
echo "<h2>Removed user successfully</h2>";

?>

<a href="index.php">Back home</a>
