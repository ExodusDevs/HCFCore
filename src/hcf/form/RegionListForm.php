<?php

namespace hcf\form;

use libs\formapi\{
  MenuForm,
  MenuOption
};

use pocketmine\player\Player;

use hcf\Loader;

class RegionListForm extends MenuForm
{
  
  public function __construct(array $buttons)
  {
    parent::__construct("Region List", "", $buttons, function(Player $player, MenuOption $selectedOption): void {
      $text = $selectedOption->getText();
      $region = Loader::getInstance()->getRegionManager()->getRegion($text);
      $stats = implode("\n", ["name" => $region->getName(), "custom_name" => $region->getCustomName(), "pvp_rule" => $region->getPvpRule(), "block_rule" => $region->getBlockRule(), "hunger_rule" => $region->getHungerRule(), "world" => $region->getWorld()->getFolderName(), "first_position" => $region->getFirstPosition()->__toString(), "second_position" => $region->getSecondPosition()->__toString()]);
      $player->sendForm(new RegionStatsForm($stats));
    });
  }
  
}
