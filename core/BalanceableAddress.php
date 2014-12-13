<?php

namespace Core;

interface BalanceableAddress {

  public function fetchBalance($address, \Db\Logger $logger);

}
