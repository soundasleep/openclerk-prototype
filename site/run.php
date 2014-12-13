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

class DiscoveredComponentsJobTypeMapper implements \Jobs\JobTypeMapper {

  function findJobType($job_type) {
    return DiscoveredComponents\Jobs::getInstance($job_type);
  }

}

// run jobs
$mapper = new DiscoveredComponentsJobTypeMapper();
$runner = new Jobs\JobsRunner($mapper);
$runner->runOne(db(), $logger);

?>

<a href="index.php">Back home</a>
