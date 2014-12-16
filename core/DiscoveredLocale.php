<?php

namespace Core;

abstract class DiscoveredLocale implements \Openclerk\Locale {

  function __construct($code, $file) {
    $this->code = $code;
    $this->file = $file;
  }

  function getKey() {
    return $this->code;
  }

  function load() {
    if (!file_exists($this->file)) {
      throw new \Openclerk\LocaleException("Could not find locale file for '" . $this->file . "'");
    }
    $result = array();
    require($this->file);
    return $result;
  }

}
