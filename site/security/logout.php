<?php

$user = Users\User::logout(db());
echo "<h2>Logged out successfully</h2>";

echo link_to(url_for("index"), "Back home");
