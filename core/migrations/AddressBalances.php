<?php

namespace Core\Migrations;

class AddressBalances extends \Db\Migration {

  /**
   * Apply only the current migration.
   * @return true on success or false on failure
   */
  function apply(\Db\Connection $db) {
    $q = $db->prepare("CREATE TABLE address_balances (
      id int not null auto_increment primary key,
      user_id int not null,
      address_id int not null,
      created_at timestamp not null default current_timestamp,

      balance decimal(24, 8) not null,
      is_recent tinyint not null default 0,
      is_daily_data tinyint not null default 0,
      created_at_day mediumint not null,

      INDEX(user_id, address_id),
      INDEX(is_recent),
      INDEX(is_daily_data)
    );");
    return $q->execute();
  }

}
