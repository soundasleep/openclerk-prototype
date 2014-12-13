<?php

namespace Core;

class AddressJob extends \Jobs\JobInstance {

  function run(\Db\Connection $db, \Db\Logger $logger) {

    $argument = $this->getArgument();

    $q = $db->prepare("SELECT * FROM addresses WHERE id=? LIMIT 1");
    $q->execute(array($argument));
    $address = $q->fetch();

    if (!$address) {
      throw new \InvalidArgumentException("No address '$argument' found");
    }
    $logger->log("Address is " . $address['address']);

    $currency = \DiscoveredComponents\Currencies::getInstance($address['currency']);
    $logger->log("Currency is " . get_class($currency));

    if (!($currency instanceof BalanceableAddress)) {
      throw new \Jobs\JobException("Currency '" . $address['currency'] . "' is not balanceable");
    }

    $balance = $currency->fetchBalance($address['address'], $logger);
    $logger->log("Address balance is $balance");

    // TODO move this into a helper method or object maybe
    $last_id = $this->insert_new_address_balance($db, $address['user_id'], $address, $balance);

    $logger->log("Inserted new address_balances id=" . $last_id);

  }

  function insert_new_address_balance(\Db\Connection $db, $user_id, $address, $balance) {

    // we have a balance; update the database
    $q = $db->prepare("INSERT INTO address_balances SET user_id=:user_id, address_id=:address_id, balance=:balance, is_recent=1, is_daily_data=1, created_at=NOW(), created_at_day=TO_DAYS(NOW())");
    $q->execute(array(
      "user_id" => $user_id,
      "address_id" => $address['id'],
      "balance" => $balance,
      // we ignore server_time
    ));
    $last_id = $db->lastInsertId();

    // disable old instances
    $q = $db->prepare("UPDATE address_balances SET is_recent=0 WHERE is_recent=1 AND user_id=:user_id AND address_id=:address_id AND id <> :id");
    $q->execute(array(
      "user_id" => $user_id,
      "address_id" => $address['id'],
      "id" => $last_id,
    ));

    // all other data from today is now old
    // NOTE if the system time changes between the next two commands, then we may erraneously
    // specify that there is no valid daily data. one solution is to specify NOW() as $created_at rather than
    // relying on MySQL
    $q = $db->prepare("UPDATE address_balances SET is_daily_data=0 WHERE is_daily_data=1 AND user_id=:user_id AND address_id=:address_id AND
      created_at_day = TO_DAYS(NOW()) AND id <> :id");
    $q->execute(array(
      "user_id" => $user_id,
      "address_id" => $address['id'],
      "id" => $last_id,
    ));

    return $last_id;

  }


}
