<?php

namespace Core;

class German extends DiscoveredLocale {

  public function __construct() {
    parent::__construct('de', __DIR__ . "/../site/generated/translations/de.php");
  }

}
