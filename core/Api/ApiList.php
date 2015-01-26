<?php

namespace Core\Api;

/**
 * API to list all available APIs.
 */
class ApiList extends \Apis\ApiList\ApiListApi {

  /**
   * This can be controlled e.g. with component-discovery
   *
   * @return a list of all Api instances that we will iterate over
   */
  function getAPIs() {
    return \DiscoveredComponents\Apis::getAllInstances();
  }

}
