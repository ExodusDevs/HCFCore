<?php

namespace hcf\manager;

use hcf\Loader;
use hcf\command\{
  LFFCommand,
  GkitCommand
};
use hcf\faction\command\FactionCommand;

use pocketmine\utils\TextFormat;

class CommandManager 
{
  public const PREFIX = "[HCF: CommandManager]";
  /**
  * @return void
  */
  public static function init() : void 
  {
    $commandMap = Loader::getInstance()->getServer()->getCommandMap();
    foreach(["plugins", "ban", "kick", "pardon", "kill"] as $command) { 
      $commandMap->unregister($commandMap->getCommand($command));
    }
    $commandMap->register("/lff", new LFFCommand());
    /*$commandMap->register("/gkit", new GkitCommand());*/
    /*$commandMap->register("/faction", new FactionCommand());*/
    $commandMap->register("/ban", new BanCommand());
    $commandMap->register("/kick", new KickCommand());
    Loader::getInstance()->getLogger()->notice(self::PREFIX . " " . TextFormat::GREEN . "Commands loaded correctly");
  }
    
}