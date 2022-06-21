<?php

namespace hcf\util;

use hcf\Loader;

trait Instances
{
  
  public function getLoader(): Loader
  {
    return Loader::getInstance();
  }
  
}