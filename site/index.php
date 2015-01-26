<?php

require(__DIR__ . "/../inc/global.php");

page_header(config('site_name'), "page_index");

?>
<h1>Openclerk2</h1>

<h2>Currencies (<?php echo number_format(count(DiscoveredComponents\Currencies::getKeys())); ?>)</h2>

<ul>
  <?php foreach (DiscoveredComponents\Currencies::getAllInstances() as $key => $cur) {
    echo "<li><span class=\"currency currency_" . $key . "\">[" . $key . "] " . $cur->getName() . " (" . get_class($cur) . ")</span></li>\n";
  } ?>
</ul>

<h2>Migrations</h2>

<?php

echo "<p>(" . implode(", ", DiscoveredComponents\Migrations::getKeys()) . ")</p>";

$logger = new \Monolog\Logger("index");

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
<li><?php echo link_to(url_for('security/signup/password'), "Signup with password"); ?></li>
<li><?php echo link_to(url_for('security/add/password'), "Add password"); ?></li>
<li><?php echo link_to(url_for('security/add/openid'), "Add OpenID identity"); ?></li>
<li><?php echo link_to(url_for('security/add/oauth2'), "Add OAuth2 identity"); ?></li>
<li><?php echo link_to(url_for('security/logout'), "Logout"); ?></li>
<li><a href="delete-user.php">Delete user</a></li>
<li><a href="password.php">Forgot password</a></li>
</ul>

<h2>Emails</h2>

<a href="email.php">Send test email</a>
<a href="email-fail.php">Send test failing email</a>

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

<h2>Jobs</h2>

<a href="queue.php">Queue jobs</a>
<a href="run.php">Run a job</a>

<h2>Addresses</h2>

<li><a href="add-address.php">Add address to current user</a></li>

<ul>
<?php

function address_format($currency, $address) {
  $instance = \DiscoveredComponents\Currencies::getInstance($currency);
  $url = false;
  if ($instance instanceof \Core\ExplorableCurrency) {
    $url = $instance->getExplorerURL($address);
  }

  $s = "<code class=\"currency currency_$currency\">";
  if ($url) {
    $s .= "<a href=\"" . htmlspecialchars($url) . "\" title=\"Explore with " . htmlspecialchars($instance->getExplorerName()) . "\">";
  }
  $s .= htmlspecialchars($address);
  if ($url) {
    $s .= "</a>";
  }
  $s .= "</code>";
  return $s;
}

function currency_format($currency, $amount) {
  return number_format($amount, 3) . " " . get_currency_abbr($currency);
}

function get_currency_abbr($currency) {
  return strtoupper($currency);
}

if ($user) {
  $q = db()->prepare("SELECT * FROM addresses ORDER BY id desc LIMIT 5");
  $q->execute(array($user->getId()));
  $addresses = $q->fetchAll();
  foreach ($addresses as $address) {
    $q = db()->prepare("SELECT * FROM address_balances WHERE user_id=? AND address_id=? AND is_recent=1 LIMIT 1");
    $q->execute(array($user->getId(), $address['id']));
    $balance = $q->fetch();
    echo "<li> <b>$address[id]</b> " . address_format($address['currency'], $address['address']);
    if ($balance) {
      echo " - " . currency_format($address['currency'], $balance['balance']);
    }
    echo "</li>\n";
  }
}

?>
</ul>

<h2>i18n</h2>

<ul>
<li><?php echo t("translated"); ?></li>
<li><?php echo t("not translated"); ?></li>
<li>one <?php echo t("address"); ?>, <?php echo plural('address', 'addresses', 10); ?></li>
<li><?php echo t("I have :colours.", array(':colours' => plural('colour', 6))); ?></li>
<li><?php $s = "to be translated" /* i18n */; ?></li>
<li>Locales available: <?php
  foreach (\Openclerk\I18n::getAvailableLocales() as $code => $locale) {
    echo "<b>" . $code . "</b> = <a href=\"locale.php?locale=" . htmlspecialchars($code) . "\">" . get_class($locale) . "</a> ";
  }
?></li>
</ul>

<h2>APIs</h2>

<ul>
<li><?php echo link_to(url_for('api/v1/currencies'), "api/v1/currencies"); ?></li>
<li><?php echo link_to(url_for('api/v1/currency/btc'), "api/v1/currency/btc"); ?></li>
<li><?php echo link_to(url_for('api/v1/currency/invalid'), "api/v1/currency/invalid"); ?></li>
<li><?php echo link_to(url_for('api/v1/apis'), "api/v1/apis"); ?></li>
<li><?php echo plural("API", count(DiscoveredComponents\Apis::getKeys())); ?></li>
<li><?php echo link_to("apis.php", "list of apis"); ?></li>
</ul>

<h2>Metrics</h2>

<ul>
<li><?php echo link_to(url_for('slow-curl'), "Slow CURL"); ?></li>
</ul>

<h2>Cache</h2>

<ul>
<li>Cache last updated <?php

function get_last_updated_cache() {
  return date('r');
}

echo \Openclerk\Cache::get(db(), "last_cache", "ignored", 30, 'get_last_updated_cache', array());

?></li>
</ul>

<?php

page_footer();

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
// - URLs and routing and relative paths
// - page templates
// - tests for components
// - components can provide assets
// - build
// - grunt wrapper for Spritify
// - addresses
// - heavy requests (OpenID)
// - forms, form validations, Javascript form validations
// - spritify with high res sprites
// - grunt wrapper for spritify
// - basic component tests

// What's next?
// - test everything! components + integration. important!
// - extended user properties
// - select2's
// - user roles
// - admin interface for exceptions
// - 2fa
// - haml for templates?
// - dos protection
// - accounts
// - graphs
// - technical indicators
// - reports
// - tests
// - i18n, UI
// - i18n for emails
// - wizards
// - content types, exception handling for content types
// - API wrappers for jobs/accounts
// - components can define UIs (maybe through DiscoveredComponents\UserInterfaces which are wrapped in templates?)
// - transactions
// - transaction reports
// - xero integration
// - metrics
// - external API statuses
// - site status metrics
// - grunt wrapper for component-discovery
// - grunt wrapper for asset-discovery
// - grunt wrapper for translation-discovery

