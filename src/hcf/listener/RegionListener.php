<?php

namespace hcf\listener;

use hcf\session\Session;
use hcf\refion\utils\RegionPosition;

use pocietmine\event\{
  Listener,
  player\PlayerInteractEvent,
  player\PlayerExhaustEvent,
  block\BlockPlaceEvent,
  block\BlockBreakEvent,
  entity\EntityDamageEvent
};

class RegionListener implements Listener
{
  private Loader $loader;
  
  public function __construct(Loader $loader)
  {
    $this->loader = $loader;
  }
  
  public function onExhaust(PlayerExhaustEvent $event): void
  {
    $player = $event->getPlayer();
    if (!$player instanceof Session || $this->loader->getServer()->isOp($player->getName())) {
      return;
    }
    $region = $this->loader->getRegionManager()->getRegionInLocation($player->getPosition());
    if ($region !== null) {
      if ($region->getHungerRule()) {
        $event->cancel();
      }
    }
  }
  
  public function onBlockPlace(BlockPlaceEvent $event): void
  {
    $player = $event->getPlayer();
    if (!$player instanceof Session || $this->loader->getServer()->isOp($player->getName())) {
      return;
    }
    $region = $this->loader->getRegionManager()->getRegionInLocation($event->getBlock()->getPosition());
    if ($region !== null) {
      if ($region->getBlockRule() === false) {
        $event->cancel();
      }
    }
  }
  
  public function onBlockBreak(BlockBreakEvent $event): void
  {
    $player = $event->getPlayer();
    if (!$player instanceof Session || $this->loader->getServer()->isOp($player->getName())) {
      return;
    }
    $region = $this->loader->getRegionManager()->getRegionInLocation($event->getBlock()->getPosition());
    if (isset($region)) {
      if ($region->getBlockRule() === false) {
        $event->cancel();
      }
    }
  }
  
  public function onDamage(EntityDamageEvent $event): void
  {
    $entity = $event->getEntity();
    if (!$entity instanceof Session) {
      return;
    }
    $region = $this->loader->getRegionManager()->getRegionInLocation($entity->getPosition());
    if (isset($region)) {
      if ($region->getPvpRule()) {
        $event->cancel();
      }
    }
  }
  
  //creacion de regiones
  public function onCreatorInteract(PlayerInteractEvent $event): void
  {
    $player = $event->getPlayer();
    if ($this->loader->getRegionManager()->isCreator($player->getName())) {
      $creator = $this->loader->getRegionManager()->getCreator($player->getName());
      if ($creator->getCountSpawn() === 1) {
        if (isset($creator->getRegionData()->first_position)) {
          $creator->setCountSpawn(2);
          return;
        }
        $creator->getRegionData()->first_position = RegionPosition::fromObject($event->getBlock()->getPosition());
        $creator->setCountSpawn(2);
      }
    }
  }
  
  public function onCreatorBreakBlock(BlockBreakEvent $event): void
  {
    $player = $event->getPlayer();
    if ($this->loader->getRegionManager()->isCreator($player->getName())) {
      $creator = $this->loader->getRegionManager()->getCreator($player->getName());
      if ($creator->getCountSpawn() === 2) {
        if (isset($creator->getRegionData()->second_position)) {
          $creator->getRegionData()->second_position = RegionPosition::fromObject($event->getBlock()->getPosition());
          $creator->setCountSpawn(0);
          $event->cancel();
          return;
        }
        $creator->getRegionData()->second_position = RegionPosition::fromObject($event->getBlock()->getPosition());
        $creator->setCountSpawn(0);
        $this->loader->getRegionManager()->setRegion($player->getName(), $creator->getRegionData());
        $event->cancel();
      }
    }
  }
  
}
