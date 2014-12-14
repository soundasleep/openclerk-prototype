<?php

require(__DIR__ . "/../vendor/autoload.php");

Openclerk\Config::merge(array(
  "site_name" => "Openclerk2 Test",
  "absolute_url" => "http://localhost/openclerk2/",

  "heavy_requests_seconds" => 20,

  "display_errors" => true,

  "database_name" => "clerk2",
  "database_username" => "clerk2",
  "database_password" => "clerk2",

  "user_password_reset_expiry" => "3 days",
  "user_password_salt" => "abc123",
  "autologin_expire_days" => 30,
  "openid_host" => "localhost",

  // in minutes
  "job_address_interval" => 0,
  "get_contents_timeout" => 10, // in seconds, default 300s
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

  Emails\Email::send($to, $template_id, $args);
}

Openclerk\Events::on('email_sent', function($email) {
  // insert in database keys
  $q = db()->prepare("INSERT INTO emails SET
    user_id=:user_id,
    to_name=:to_name,
    to_email=:to_email,
    subject=:subject,
    template_id=:template_id,
    arguments=:arguments");
  $q->execute(array(
    "user_id" => $email['user_id'],
    "to_name" => $email['to_name'],
    "to_email" => $email['to_email'],
    "subject" => $email['subject'],
    "template_id" => $email['template_id'],
    "arguments" => serialize($email['arguments']),
  ));
});

Openclerk\Events::on('user_deleted', function($user) {
  // send email
  send_email($user, "user_deleted", array(
    "id" => $user->getId(),
    "email" => $user->getEmail(),
  ));
});

session_start();

function link_to($url, $text = false) {
  if ($text === false) {
    return link_to($url, $url);
  }
  return "<a href=\"" . htmlspecialchars($url) . "\">" . htmlspecialchars($text) . "</a>";
}

// set up routes
\Openclerk\Router::addRoutes(array(
  "security/login/password" => "security/login.php",
  "security/login/:key" => "security/login-:key.php",
  "security/register/password" => "security/register.php",
  "security/register/:key" => "security/register-:key.php",
  "security/add/:key" => "security/add-:key.php",
  "security/signup/password" => "security/signup.php",
));

function page_header($title, $id = "", $arguments = array()) {
  $arguments['title'] = $title;
  $arguments['id'] = $id;
  \Pages\PageRenderer::header($arguments);
}

function page_footer($arguments = array()) {
  \Pages\PageRenderer::footer($arguments);
}

function require_template($template_id, $arguments = array()) {
  \Pages\PageRenderer::requireTemplate($template_id, $arguments);
}

\Pages\PageRenderer::addTemplatesLocation(__DIR__ . "/../templates");
\Pages\PageRenderer::addStylesheet(\Openclerk\Router::urlFor("css/default.css"));
\Pages\PageRenderer::addStylesheet(\Openclerk\Router::urlFor("generated/css/generated-scss.css"));
\Pages\PageRenderer::addStylesheet(\Openclerk\Router::urlFor("generated/css/generated.css"));
\Pages\PageRenderer::addJavascript("https://code.jquery.com/jquery-2.1.1.min.js");
\Pages\PageRenderer::addJavascript(\Openclerk\Router::urlFor("js/default.js"));
\Pages\PageRenderer::addJavascript(\Openclerk\Router::urlFor("generated/js/generated-coffee.js"));
\Pages\PageRenderer::addJavascript(\Openclerk\Router::urlFor("generated/js/generated.js"));

function user_id() {
  $user = get_user();
  return $user->getId();
}

function get_user() {
  $user = Users\User::getInstance(db());
  if (!$user) {
    // TODO redirect etc
    throw new Exception("User expected");
  }
  return $user;
}

require(__DIR__ . "/heavy.php");

// set up heavy request checks
\Openclerk\Events::on('openid_validate', function($lightopenid) {
  check_heavy_request();
});

\Openclerk\Events::on('oauth2_auth', function($oauth2) {
  check_heavy_request();
});
