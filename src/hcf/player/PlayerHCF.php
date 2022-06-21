<?php

namespace hcf\player;

use pocketmine\permission\PermissionManager;

use libs\scoreboard\Scoreboard;
use libs\cooldown\CooldownManager;

class PlayerHCF extends \pocketmine\player\Player
{
  private ?CooldownManager $cooldownManaer = null;
  
  private ?string $class = null;
  
  public function __construct($server, $session, $playerInfo, $authenticated, $spawnLocation, $namedtag) {
    parent::__construct($server, $session, $playerInfo, $authenticated, $spawnLocation, $namedtag);
    
    if ($this->cooldownManager === null) {
      $this->cooldownManager = new CooldownManager();
    }
  }
  
  public function addPermission(string $permission): void
  {
    
  }
  
  public function setClass(?string $name): void
  {
    $this->class = $name;
  }
  
  public function getClass(): ?string
  {
    return $thid->class;
  }
  
}