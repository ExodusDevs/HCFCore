<?php

namespace hcf\fight;

use pocketmine\entity\{EntityDataHelper, EntityFactory};
use pocketmine\item\ItemFactory;
use pocketmine\world\World;
use pocketmine\nbt\tag\CompoundTag;

use hcf\fight\logger\LogoutZombie;
use hcf\item\{
  Snowball,
  EnderPearl,
  AntiTrapper
};

class FightManager
{
  
  public function init(): void
  {
    $entity = EntityFactory::getInstance();
    $item = ItemFactory::getInstance();
    $entity->register(LogoutZombie::class, function(World $world, CompoundTag $tag): LogoutZombie {
      return new LogoutZombie(EntityDataHelper::parseLocation($tag, $world), $tag);
    }, ["Zombie", "minecraft:zombie"]);
    $item->register(new Snowball(), true);
    $item->register(new AntiTrapper(), true);
    $item->register(new EnderPearl(), true);
  }
  
}