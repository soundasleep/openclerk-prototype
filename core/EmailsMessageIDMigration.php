<?php

namespace Core;

class EmailsMessageIDMigration extends \Db\Migration {

  function getParents() {
    return array(new EmailsMigration());
  }

  /**
   * Apply only the current migration.
   * @return true on success or false on failure
   */
  function apply(\Db\Connection $db) {
    $q = $db->prepare("ALTER TABLE emails ADD message_id varchar(255) null;");
    return $q->execute();
  }

}
