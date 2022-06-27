<?php

namespace hcf\form;

use InvalidArgumentException;

use pocketmine\player\Player;

use hcf\Loader;
use hcf\region\utils\RegionData;

use libs\formapi\{
  CustomForm,
  CustomFormResponse,
  element\Input
};

class RegionCreateForm extends CustomForm
{
  
  public function __construct()
  {
    parent::__construct("Create Region", [
      new Input("name", "Region name", "Spawn"),
      new Input("custom_name", "Region custom name", "§l§oSpawn §e(Non-Deathban)"),
      new Input("world", "Region world name", "world,overworld,end,nether")
    ], function(Player $player, CustomFormResponse $response): void {
      $name = $response->getString("name");
      $custom_name = $response->getString("custom_name");
      $world = $response->getString("world");
      $pvp_rule = $response->getBool("pvp_rule");
      $block_rule = $response->getBool("block_rule");
      $hunger_rule = $response->getBool("hunger_rule");
      if (strlen($name) < 4 || strlen($world) < 5) {
        throw new InvalidArgumentException("the region name is less than 4 characters and the world is less than 5 characters");
      }
      if (Loader::getInstance()->getRegionManager()->worldExistsRegion($world)) {
        throw new  InvalidArgumentException("there is already a region with that world"); 
      }
      $regionData = new RegionData();
      $regionData->name = $name;
      $regionData->custom_name = $custom_name;
      $regionData->pvp_rule = $pvp_rule;
      $regionData->block_rule = $block_rule;
      $regionData->hunger_rule = $hunger_rule;
      $regionData->world = $player->getServer()->getWorldManager()->getWorldByName($world);
      Loader::getInstance()->getRegionManager()->createRegion($regionData);
      Loader::getInstance()->getRegionManager()->addCreator($player->getName(), $name, $regionData);
    });
  }
  
}
