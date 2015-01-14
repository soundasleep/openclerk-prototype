<?php

require(__DIR__ . "/../inc/global.php");

$lister = new \Apis\ApiList\ApiLister();
$apis = $lister->processAPIs(\DiscoveredComponents\Apis::getAllInstances());

print_r($apis);

?>

<a href="index.php">Back home</a>
