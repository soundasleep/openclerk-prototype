<?php

require(__DIR__ . "/../inc/global.php");

?>
<h1>Openclerk2</h1>

<h2>Currencies (<?php echo number_format(count(DiscoveredComponents\Currencies::getKeys())); ?>)</h2>

<ul>
  <?php foreach (DiscoveredComponents\Currencies::getAllInstances() as $key => $cur) {
    echo "<li>[" . $key . "] " . $cur->getName() . " (" . get_class($cur) . ")</li>\n";
  } ?>
</ul>

<h2>Migrations</h2>

<?php

echo "<p>(" . implode(", ", DiscoveredComponents\Migrations::getKeys()) . ")</p>";

class MyLogger extends \Db\Logger {
  function log($s) {
    echo "<li>" . htmlspecialchars($s) . "</li>";
  }
  function error($s) {
    echo "<li class=\"error\" style=\"color:red;\">" . htmlspecialchars($s) . "</li>";
  }
}

$logger = new MyLogger();

class AllMigrations extends \Db\Migration {
  function getParents() {
    return array(new Db\BaseMigration()) + DiscoveredComponents\Migrations::getAllInstances();
  }

  function getName() {
    return "AllMigrations_" . md5(implode(",", array_keys($this->getParents())));
  }
}

$migrations = new AllMigrations(db());
if ($migrations->hasPending(db())) {
  echo "<h3>Installing migrations</h3>";
  echo "<ul>";
  $migrations->install(db(), $logger);
  echo "</ul>";
}

?>

<h2>Users</h2>

<?php
print_r($_SESSION);

$user = Users\User::getInstance(db());
if ($user) {
  echo "Logged in as $user";
} else {
  echo "Not logged in";
}
?>

<ul>
<li><?php echo link_to(url_for('security/login/password'), "Login with password"); ?></li>
<li><?php echo link_to(url_for('security/login/openid'), "Login with OpenID"); ?></li>
<li><?php echo link_to(url_for('security/login/oauth2'), "Login with OAuth2"); ?></li>
<li><?php echo link_to(url_for('security/register/password'), "Register with password"); ?></li>
<li><?php echo link_to(url_for('security/register/openid'), "Register with OpenID"); ?></li>
<li><?php echo link_to(url_for('security/register/oauth2'), "Register with OAuth2"); ?></li>
<li><?php echo link_to(url_for('security/add/password'), "Add password"); ?></li>
<li><?php echo link_to(url_for('security/add/openid'), "Add OpenID identity"); ?></li>
<li><?php echo link_to(url_for('security/add/oauth2'), "Add OAuth2 identity"); ?></li>
<li><?php echo link_to(url_for('security/logout'), "Logout"); ?></li>
<li><a href="delete-user.php">Delete user</a></li>
<li><a href="password.php">Forgot password</a></li>
</ul>

<h2>Emails</h2>

<a href="email.php">Send test email</a>

<h2>Exceptions</h2>

<a href="exceptions-throw.php">Throw exception</a>
<a href="exceptions-compile.php">Compile error</a>
<a href="exceptions-fatal.php">Fatal error</a>
<a href="exceptions-typed.php">Typed exception</a>

<ul>
<?php

$q = db()->prepare("SELECT * FROM uncaught_exceptions ORDER BY id desc LIMIT 5");
$q->execute();
$exceptions = $q->fetchAll();
foreach ($exceptions as $e) {
  echo "<li> <b>$e[id]</b> $e[message] ($e[class_name]) - $e[filename]:$e[line_number] ($e[argument_type] $e[argument_id])</li>\n";
}

?>
</ul>

<h2>Routing</h2>

<a href="router.php">Test router</a>

<?php

// What's done?
// - component management
// - config
// - database
// - users
// - jobs
// - sending emails
// - html emails
// - exception handling
// - users without emails

// What's next?
// - URLs and routing and relative paths
// - page templates
// - tests for components
// - extended user properties
// - form validations
// - user roles
// - admin interface for exceptions
// - heavy requests (OpenID)
// - forgotten passwords
// - multiple OpenIDs/OAuths per user
// - addresses
// - accounts
// - graphs
// - technical indicators
// - reports
// - components can provide assets
// - tests
// - build
// - coffeescript, sass
// - i18n, UI
// - content types, exception handling for content types
// - API wrappers for jobs/accounts
// - components can define UIs (maybe through DiscoveredComponents\UserInterfaces which are wrapped in templates?)
// - transactions
// - metrics

