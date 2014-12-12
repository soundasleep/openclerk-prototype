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

<a href="login.php">Login with password</a>
<a href="login-openid.php">Login with OpenID</a>
<a href="login-oauth2.php">Login with OAuth2</a>
<a href="register.php">Register with password</a>
<a href="register-openid.php">Register with OpenID</a>
<a href="register-oauth2.php">Register with OAuth2</a>
<a href="logout.php">Logout</a>

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

// What's next?
// - tests for components
// - users without emails
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

