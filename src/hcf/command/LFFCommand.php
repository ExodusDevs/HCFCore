<?php

namespace hcf\command;

use pocketmine\command\{
  CommandSender,
  Command
};
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

use hcf\Loader;
use hcf\manager\FactionManager;

class LFFCommand extends Command 
{

  public function __construct()
  {
    parent::__construct("lff", "Send the message: Looking for Faction.", "/lff");   
  }

  public function execute(CommandSender $sender, string $label, array $args): void 
  {
    if (!$sender instanceof Player) {
      return;
    }
    if(FactionManager::getInstance()->isFaction($sender->getName())) {
      $sender->sendMessage(TextFormat::RED . "You cannot run this command if you are already in a faction.");
      return;
    }
    Loader::getInstance()->getServer()->broadcastMessage(TextFormat::BLACK . "--------------------------------------------------");
    Loader::getInstance()->getServer()->broadcastMessage(TextFormat::BOLD . TextFormat::AQUA . $sender->getName() . TextFormat::DARK_GRAY . " is now Looking For Faction.");
    Loader::getInstance()->getServer()->broadcastMessage(TextFormat::BLACK . "--------------------------------------------------");
  }
    
}