<?php

namespace hcf\provider;

use hcf\Loader;

class YAMLProvider
{

  public function __construct(Loader $core)
  {
    $core->saveResource("scoreboard_settings.yml");
    $core->saveResource("motd_settings.yml");
    if (!is_dir($folder = $core->getDataFolder() . "bans" . DIRECTORY_SEPARATOR)) {
      @mkdir($folder);
    }
    if (!is_dir($folder = $core->getDataFolder() . "factions" . DIRECTORY_SEPARATOR)) {
      @mkdir($folder);
    }
    if (!is_dir($folder = $core->getDataFolder() . "players" . DIRECTORY_SEPARATOR)) {
      @mkdir($folder);
    }
    if (!is_dir($folder = $core->getDataFolder() . "kits" . DIRECTORY_SEPARATOR)) {
      @mkdir($folder); //@ ignora el error
    }
    if (!is_dir($folder = $core->getDataFolder() . "koths" . DIRECTORY_SEPARATOR)) {
      @mkdir($folder); //@ ignora el error
    }
    if (!is_dir($folder = $core->getDataFolder() . "reports" . DIRECTORY_SEPARATOR)) {
      @mkdir($folder); //@ ignora el error
    }
  }

}