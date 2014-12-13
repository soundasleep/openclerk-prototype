<?php

namespace Core;

interface ExplorableCurrency {

  function getExplorerURL($address);

  function getExplorerName();

}
