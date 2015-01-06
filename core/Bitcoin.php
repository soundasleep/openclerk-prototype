<?php

namespace Core;

use \Monolog\Logger;

class Bitcoin implements Currency, ExplorableCurrency, BalanceableAddress {
  function getName() {
    return "Bitcoin";
  }

  function getCode() {
    return "btc";
  }

  function getExplorerURL($address) {
    return "https://blockchain.info/address/" . urlencode($address);
  }

  function getExplorerName() {
    return "blockchain.info";
  }

  function fetchBalance($address, Logger $logger) {
    $url = "https://blockchain.info/q/addressbalance/" . urlencode($address) . "?confirmations=" . \Openclerk\Config::get('btc_confirmations', 0);

    // TODO blockchain API key

    $logger->info("Fetching $url");
    $response = \Core\Fetch::get($url);

    // TODO is_numeric check

    $balance = $response;
    $divisor = 1e8;   // divide by 1e8 to get btc balance

    return $balance / $divisor;
  }

}
