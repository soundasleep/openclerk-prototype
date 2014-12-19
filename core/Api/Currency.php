<?php

namespace Core\Api;

/**
 * API to get a single currency properties.
 */
class Currency extends \Apis\Api {

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

}
