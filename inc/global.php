<?php

require(__DIR__ . "/../vendor/autoload.php");

Openclerk\Config::merge(array(
  "site_name" => "Openclerk2 Test",

  "database_name" => "clerk2",
  "database_username" => "clerk2",
  "database_password" => "clerk2",

  "user_password_salt" => "abc123",
  "autologin_expire_days" => 30,
  "openid_host" => "localhost",
));

if (file_Exists(__DIR__ . "/private.php")) {
  require(__DIR__ . "/private.php");
}

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

function send_email($to, $template_id, $args = array()) {
  $args['site_name'] = config('site_name');
  // TODO site_url
  $args['site_email'] = config('phpmailer_from');

  Emails\Email::send(db(), $to, $template_id, $args);
}

session_start();
