<?php

namespace hcf\command\sub;

use hcf\command\SubCommand;
use hcf\form\RegionListForm;
use hcf\Loader;

use pocketmine\command\CommandSender;

class RegionListSubCommand extends SubCommand
{
  
  public function __construct()
  {
    parent::__construct("list", "", "/region list");
  }
  
  public function execute(CommandSemder $sender, string $label, array $args): void
  {
    $buttons = [];
    foreach(Loader::getInstance()->getRegionManager()->getRegions() as $region) {
      if (is_object($region)) {
        $buttons[] = new MenuOption($region->getName());
      }
    }
    $sender->sendForm(new RegionListForm($buttons));
  }
  
}
