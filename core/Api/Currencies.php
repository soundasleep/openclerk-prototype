<?php

namespace Core\Api;

/**
 * API to get a list of currencies and their properties.
 */
class Currencies extends \Apis\CachedApi {

  function getJSON($arguments) {
    $currencies = \DiscoveredComponents\Currencies::getAllInstances();
    $result = array();
    foreach ($currencies as $key => $cur) {
      $result[$key] = array(
        'code' => $cur->getCode(),
        'title' => $cur->getName(),
      );
    }

    return $result;
  }

  function getEndpoint() {
    return "/api/v1/currencies";
  }

  function getHash($arguments) {
    return "";    // there is nothing to hash
  }

}
