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
