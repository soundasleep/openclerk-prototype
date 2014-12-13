<?php

require(__DIR__ . "/../inc/global.php");

class MyLogger extends Db\Logger {
  function log($s) {
    echo "<li>" . htmlspecialchars($s) . "</li>\n";
  }
  function error($e) {
    echo "<li class=\"error\">" . htmlspecialchars($e) . "</li>\n";
  }
}

$logger = new MyLogger();

// queue up jobs
$queuer = new Jobs\JobsQueuer(DiscoveredComponents\Jobs::getAllInstances());
$queuer->doQueue(db(), $logger);

?>

<a href="index.php">Back home</a>
