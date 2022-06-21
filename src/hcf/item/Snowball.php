<?php

namespace hcf\item;

use pocketmine\item\{
  ProjectileItem,
  VanillaItems,
  ItemIdentifier
};
use pocketmine\entity\projectile\Throwable;
use pocketmine\entity\Location;
use pocketmine\player\Player;

use hcf\item\entity\Snowball as SnowballEntity;

class Snowball extends ProjectileItem
{
  
  public function __construct()
  {
    parent::__construct(new ItemIdentifier(VanillaItems::SNOWBALL()->getId(), VanillaItems::SNOWBALL()->getMeta()), "§bSnowball");
  }
  
  public function getMaxStackSize(): int
  {
    return 16;
  }
  
  public function getThrowForce(): float
  {
    return 1.6;
  }
  
  public function createEntity(Location $location, Player $player): Throwable
  {
    return new SnowballEntity($location, $player);
  }
  
}