<?php

namespace hcf\item;

use pocketmine\item\{
  VanillaItems,
  ItemIdentifier
};
use pocketmine\nbt\tag\CompoundTag;

class AntiTrapper extends Item
{
  
  public function __construct()
  {
    parent::__construct(new ItemIdentifier(VanillaItems::BONE()->getId(), VanillaItems::BONE()->getMeta()), "Bone"); 
  }
  
}