<?php

require(__DIR__ . "/../inc/global.php");

$logger = new \Monolog\Logger('Queue');
$logger->pushHandler(new OutputHandler());

// queue up jobs
$queuer = new Jobs\JobsQueuer(DiscoveredComponents\Jobs::getAllInstances());
$queuer->doQueue(db(), $logger);

?>

<a href="index.php">Back home</a>
