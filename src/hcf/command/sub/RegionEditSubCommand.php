<?php

namespace hcf\command\sub;

use hcf\command\SubCommand;
use hcf\Loader;
use hcf\form\RegionEditForm;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class RegionEditSubCommand extends SubCommand
{
  
  public function __construct()
  {
    parent::__construct("edit", "Crea la region en un mapa especifico", "/region edit <name> <form: world|pvp_rule|block_rule|hunger_rule>");
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if (Loader::getInstance()->getRegionManager()->isRegion($args[0])) {
      $sender->sendForm(new RegionEditForm());
    }
  }
  
}
