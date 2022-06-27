<?php

/**
*  __  __  ____     ____           ____     _____   ____    ____      
* /\ \/\ \/\  _`\  /\  _`\        /\  _`\  /\  __`\/\  _`\ /\  _`\    
* \ \ \_\ \ \ \/\_\\ \ \L\_\      \ \ \/\_\\ \ \/\ \ \ \L\ \ \ \L\_\  
*  \ \  _  \ \ \/_/_\ \  _\/_______\ \ \/_/_\ \ \ \ \ \ ,  /\ \  _\L  
*   \ \ \ \ \ \ \L\ \\ \ \//\______\\ \ \L\ \\ \ \_\ \ \ \\ \\ \ \L\ \
*    \ \_\ \_\ \____/ \ \_\\/______/ \ \____/ \ \_____\ \_\ \_\ \____/
*     \/_/\/_/\/___/   \/_/           \/___/   \/_____/\/_/\/ /\/___/ 
*
**/

namespace hcf;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\{
  Config,
  TextFormat,
  SingletonTrait
};

use libs\invmenu\InvMenuHandler;
 
use hcf\EventListener;
use hcf\provider\{
  MySQLProvider,
  JsonProvider
};
use hcf\util\Utils;
use hcf\discord\Logger;
use hcf\fight\FightManager;
use hcf\manager\{
  CommandManager,
  KitManager,
  RegionManager
};

class Loader extends PluginBase {
    
  use SingletonTrait;
   
  public const PLUGIN_VERSION = "1.9.0";
   
  private static Utils $utils;
   
  private MySQLProvider $sqlProvider;
   
  private JsonProvider $jsonProvider;
  
  private Logger $discord;
   
  private RegionManager $regionManager;
  
  public function onLoad(): void 
  {
    self::setInstance($this);
      if (self::PLUGIN_VERSION !== $this->getDescription()->getVersion()) {
        $this->getLogger()->error("Please don't change the `plugin.yml` version, that helps us investigate plugin errors, thanks");
        $this->getLogger()->warning("Any changes you make to the plugin version will not be supported by us.");
        $this->getServer()->getPluginManager()->disablePlugin($this);
        $this->getServer()->shutdown();
      }
  }
   
  public function onEnable(): void
  {
    if (!InvMenuHandler::isRegistered()) {
      InvMenuHandler::register($this);
    }
    $this->sqlProvider = new MySQLProvider($this);
    $this->jsonProvider = new JsonProvider($this);
    self::$utils = new Utils();
     
    //MOTD (soon task)
    $this->getServer()->getNetwork()->setName(TextFormat::colorize(($this->getConfig()->get("server-name")) . "&r | " . $this->getConfig()->get("server-color") . $this->getConfig()->get("server-description")));

    //Discord Wehbook
    $this->discord = new Logger($this->getConfig()->get("webhook-url")/*, $this->getConfig()->get("webhook-check")*/);
     
    //Global Events
    $event = new EventListener();
    $event->init();
     
    //Soon. AntiCheat
    $fight = new FightManager();
    $fight->init();
    
    //Global Commands
    CommandManager::init();
    
    //Kit
    KitManager::init();
    
    //Region
    $this->regionManager = new RegionManager($this);
    
    $this->getLogger()->info("=========================================="); 
    $this->getLogger()->notice("
 **      **   ******  ********         ******    *******   *******   ********
/**     /**  **////**/**/////         **////**  **/////** /**////** /**///// 
/**     /** **    // /**             **    //  **     //**/**   /** /**      
/**********/**       /*******  *****/**       /**      /**/*******  /******* 
/**//////**/**       /**////  ///// /**       /**      /**/**///**  /**////  
/**     /**//**    **/**            //**    **//**     ** /**  //** /**      
/**     /** //****** /**             //******  //*******  /**   //**/********
//      //   //////  //               //////    ///////   //     // //////// 
");
    $this->getLogger()->notice("Plugin enabled!!");
    $author = implode(",", $this->getDescription()->getAuthors());
    $this->getLogger()->notice("Authors: §b{$author}");
    $this->getLogger()->info("==========================================");
  }
   
  public static function getInstance(): Loader
  {
     return self::$instance;
  }
   
  public static function getDiscord(): Logger
  {
     return $this->discord;
  }
  
  public static function getUtils() : Utils 
  {
        return self::$utils;
  }
   
  public function getJsonProvider(): JsonProvider
  {
     return $this->jsonProvider;
  }
   
  public function getMySQLProvider(): MySQLProvider
  {
     return $this->sqlProvider;
  }
  
  public function getRegionManager(): RegionManager
  {
    return $this->regionManager;
  }
  
}