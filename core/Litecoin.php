<?php

namespace Core;

class Litecoin implements Currency {
  function getName() {
    return "Litecoin";
  }

  function getCode() {
    return "ltc";
  }

}
