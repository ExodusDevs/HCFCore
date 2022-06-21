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
  YAMLProvider
};
use hcf\util\Utils;
use hcf\discord\Logger;
use hcf\fight\FightManager;
use hcf\manager\{
  CommandManager,
  KitManager
};

class Loader extends PluginBase {
    
  use SingletonTrait;
   
  public const PLUGIN_VERSION = "1.9.0";
   
  private static Utils $utils;
   
  private MySQLProvider $sqlProvider;
   
  public $config = [];

  private Logger $discord;
   
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
    $this->ymlProvider = new YAMLProvider($this);
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
  // ranks
$files = ["players"];
        foreach ($files as $file) {
            if (!file_exists($this->getDataFolder().$file)) {
                @mkdir($this->getDataFolder().$file);
                $this->getLogger()->info(TextFormat::GRAY."Las carpetas ".TextFormat::GREEN."{$file} ".TextFormat::GRAY."se crearon con exito");
            }else{
                $this->getLogger()->warning(TextFormat::RED."ya fueron creadas las carpetas ".TextFormat::GREEN."{$file}");
            }
        
        #SAVE RESOURCES
        $this->saveResource("config.json"); $config = new Config($this->getDataFolder()."config.json", Config::JSON);

    }

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
   
  public function getYAMLProvider(): YAMLProvider
  {
     return $this->ymlProvider;
  }
   
  public function getMySQLProvider(): MySQLProvider
  {
     return $this->sqlProvider;
  }
   
}
