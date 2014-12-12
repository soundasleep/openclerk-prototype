<?php

require(__DIR__ . "/../inc/global.php");

class TypedException extends Exception implements \Openclerk\TypedException {
  public function __construct($message, $id) {
    parent::__construct($message);
    $this->id = $id;
  }

  public function getArgumentId() {
    return $this->id;
  }

  public function getArgumentType() {
    return "test";
  }
}

throw new TypedException("Uncaught typed exception", 1);
