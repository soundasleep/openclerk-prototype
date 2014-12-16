<?php

namespace Core;

class French extends DiscoveredLocale {

  public function __construct() {
    parent::__construct('fr', __DIR__ . "/../site/generated/translations/fr.php");
  }

}
