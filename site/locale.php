<?php

require(__DIR__ . "/../inc/global.php");

Openclerk\I18n::setLocale(require_get("locale"));
echo "Locale set to " . Openclerk\I18n::getCurrentLocale();

?>

<a href="index.php">Back home</a>
