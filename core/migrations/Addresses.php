<?php

namespace Core\Migrations;

class Addresses extends \Db\Migration {

  /**
   * Apply only the current migration.
   * @return true on success or false on failure
   */
  function apply(\Db\Connection $db) {
    $q = $db->prepare("CREATE TABLE addresses (
      id int not null auto_increment primary key,
      user_id int not null,
      created_at timestamp not null default current_timestamp,

      currency varchar(3) not null,
      address varchar(36) not null,
      title varchar(255) null,
      is_received tinyint not null default 0,

      last_queue timestamp null,

      INDEX(user_id),
      INDEX(is_received)
    );");
    return $q->execute();
  }

}
