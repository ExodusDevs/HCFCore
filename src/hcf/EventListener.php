<?php

namespace hcf;

use hcf\Loader;

use hcf\listener\{
  BaseListener,
  PlayerListener,
  RegionListener
};

class EventListener 
{
  
  public function init(): void
  {
    $loader = Loader::getInstance();
    //$loader->getServer()->getPluginManager()->registerEvents(new BaseListener(), $loader);
    //$loader->getServer()->getPluginManager()->registerEvents(new PlayerListener(), $loader);
    $loader->getServer()->getPluginManager()->registerEvents(new RegionListener($loader), $loader);
  }
  
}
