<?php

namespace Core;

class AddressJobType extends \Jobs\JobType {

  /**
   * Get a list of all job instances that should be run soon.
   * @return a list of job parameters
   */
  function getPending(\Db\Connection $db) {
    $q = $db->prepare("SELECT * FROM addresses WHERE ISNULL(last_queue) OR last_queue < DATE_SUB(NOW(), INTERVAL " . \Openclerk\Config::get("job_address_interval") . " MINUTE)");
    $q->execute();

    $result = array();
    while ($address = $q->fetch()) {
      $result[] = array(
        "job_type" => $this->getName(),
        "arg" => $address['id'],
      );
    }

    return $result;
  }

  /**
   * Prepare a {@link JobInstance} that can be executed from
   * the given parameters.
   */
  function createInstance($params) {
    return new AddressJob($params);
  }

  /**
   * Do any post-job-queue behaviour e.g. marking the job queue
   * as checked.
   */
  function finishedQueue(\Db\Connection $db, $jobs) {
    foreach ($jobs as $job) {
      $q = $db->prepare("UPDATE addresses SET last_queue=NOW() WHERE id=?");
      $q->execute(array($job['arg']));
    }
  }

  function getName() {
    return "address";
  }

}
