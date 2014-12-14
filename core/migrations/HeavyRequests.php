<?php

namespace Core\Migrations;

class HeavyRequests extends \Db\Migration {

  /**
   * Apply only the current migration.
   * @return true on success or false on failure
   */
  function apply(\Db\Connection $db) {
    $q = $db->prepare("CREATE TABLE heavy_requests (
      id int not null auto_increment primary key,
      created_at timestamp not null default current_timestamp,

      user_ip varchar(64) not null,
      last_request timestamp not null,

      INDEX(user_ip)
    );");
    return $q->execute();
  }

}
