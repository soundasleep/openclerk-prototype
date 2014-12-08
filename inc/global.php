<?php

require(__DIR__ . "/../vendor/autoload.php");

Openclerk\Config::merge(array(
  "database_name" => "clerk2",
  "database_username" => "clerk2",
  "database_password" => "clerk2",
));

function config($key, $default = null) {
  return Openclerk\Config::get($key, $default);
}

function db() {
  return new \Db\Connection(
    config("database_name"),
    config("database_username"),
    config("database_password")
  );
}
