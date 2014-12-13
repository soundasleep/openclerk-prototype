<?php

namespace Core;

class Bitcoin implements Currency, ExplorableCurrency {
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

}
