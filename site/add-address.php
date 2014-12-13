<?php

require(__DIR__ . "/../inc/global.php");

$address = "1DhfWpaaskUMEMJjBaExGMXgHwT2WWhxCF";
$currency = "btc";

$q = db()->prepare("INSERT INTO addresses SET
  user_id=:user_id,
  address=:address,
  currency=:currency");
$q->execute(array(
  "user_id" => user_id(),
  "address" => $address,
  "currency" => $currency,
));

?>

<a href="index.php">Back home</a>
