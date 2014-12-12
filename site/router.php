<?php

/**
 * Test router implementation
 */

require(__DIR__ . "/../inc/global.php");

$path = require_get("path", "security/login/password");

try {
  \Openclerk\Router::process($path);
} catch (\Openclerk\RouterException $e) {
  header("HTTP/1.0 404 Not Found");
  echo "<h1>" . htmlspecialchars($e->getMessage()) . "</h1>\n\n";
  if (\Openclerk\Config::get('display_errors', false)) {
    print_exception_trace($e);
  }
}
