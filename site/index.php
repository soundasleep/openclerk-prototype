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
