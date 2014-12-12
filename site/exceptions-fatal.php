<?php

require(__DIR__ . "/../inc/global.php");

function redefined() {
  // the second definition should throw a Fatal Error
  function redefined() {

  }
}

redefined();

// note however we can't catch some fatal errors, such as two identical
// function definitions within a single include
