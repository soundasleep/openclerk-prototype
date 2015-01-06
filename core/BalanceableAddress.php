<?php

namespace Core;

use \Monolog\Logger;

interface BalanceableAddress {

  public function fetchBalance($address, Logger $logger);

}
