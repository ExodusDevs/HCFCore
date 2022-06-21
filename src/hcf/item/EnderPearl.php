<?php

namespace hcf\item;

use pocketmine\item\{
  ItemIdentifier,
  ProjectileItem,
  VanillaItems
};
use pocketmine\entity\Location;
use pocketmine\entity\projectile\Throwable;
use pocketmine\player\Player;

use hcf\item\entity\EnderPearl as EnderPearlEntity;

class EnderPearl extends ProjectileItem
{
  
  public function __construct()
  {
    parent::__construct(new ItemIdentifier(VanillaItems::ENDER_PEARL()->getId(), VanillaItems::ENDER_PEARL()->getMeta()), "Ender Pearl");
  }
  
  public function getMaxStackSize(): int
  {
    return 16;
  }
  
  public function getThrowForce(): float
  {
    return 2.5;
  }
  
  public function getCooldownTicks(): int
  {
    return 15;
  }
  
}