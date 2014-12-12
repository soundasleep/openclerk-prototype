<?php

/**
 * Test router implementation
 */

require(__DIR__ . "/../inc/global.php");

$path = require_get("path", "security/login/password");

\Openclerk\Router::process($path);
