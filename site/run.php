<?php

require(__DIR__ . "/../inc/global.php");

$logger = new \Monolog\Logger('Run');
$logger->pushHandler(new OutputHandler());

class DiscoveredComponentsJobTypeMapper implements \Jobs\JobTypeMapper {

  function findJobType($job_type) {
    return DiscoveredComponents\Jobs::getInstance($job_type);
  }

}

// run jobs
$mapper = new DiscoveredComponentsJobTypeMapper();
$runner = new Jobs\JobsRunner($mapper);

if (require_get("id", false)) {
  $job = $runner->runJob(require_get("id"), db(), $logger);
} else {
  $job = $runner->runOne(db(), $logger);
}

?>

<a href="run.php?id=<?php echo htmlspecialchars($job['id']); ?>">Run again</a>
<a href="index.php">Back home</a>
