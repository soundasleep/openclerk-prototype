<?php

namespace Core\Api;

/**
 * API to get a single currency properties.
 */
class Currency extends \Apis\CachedApi {

  function getJSON($arguments) {
    $cur = \DiscoveredComponents\Currencies::getInstance($arguments['currency']);
    $result = array(
      'code' => $cur->getCode(),
      'title' => $cur->getName(),
    );

    return $result;
  }

  function getEndpoint() {
    return "/api/v1/currency/:currency";
  }

  function getHash($arguments) {
    return substr($arguments['currency'], 0, 32);
  }

}
