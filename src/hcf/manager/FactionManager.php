<?php

namespace hcf\manager;

use pocketmine\utils\SingletonTrait;
use pocketmine\Server;

use hcf\Loader;
use hcf\player\PlayerHCF;

class FactionManager 
{
  use SingletonTrait;
  
  public const OWNER = "owner";
  public const MEMBER = "member";
  
  public const DTR_REGENERATE_TIME = 3600;
  
  public array $factions = []; 
  
  public function init(): void
  {
    if (empty($this->getFactions())) {
      echo "no hay factions";
      return;
    }
  }
  
  public function getFactions(): array
  {
    return $this->factions;
  }
  
  public function getFaction(string $name): ?Faction
  {
    return ($this->factions[$name] instanceof Faction) ? $this->factions[$name] : null;
  }
  
  public function createFaction(string $name, PlayerHCF $owner): void
  {
    if ($this->isFaction($name)) {
      return;
    }
    $dtr_max = Loader::getInstance()->getConfig("faction")["maxplayers"] + .5;
    /** @var Faction(factionName, positionHome, membersArray, balanceInt, dtrFloat) **/
    $this->factions[$name] = new Faction($name, null, [$owner->getName()], 0, $dtr_max);
    $owner->setFaction($this->factions[$name]);
    /** @funciton Set the player role for the faction **/
    $owner->setFactionRank(self::OWNER);
  }
  
  public function joinFaction(Player $owner, string $username, string $factionName): void
  {
    if ($this->isFaction($username)) {
      return;
    }
    $user = Loader::getInstance()->getServer()->getPlayerByPrefix($username);
    $name = $user instanceof PlayerHCF ? $user->getName() : null;
    $owner->getFaction()->setMembers($name);
    $owner->sendMessage("clo");
    foreach($owner->getFaction()->getMembers() as $member) {
      $player = Loader::getInstance()->getServer()->getPlayerByPrefix($member);
      if ($player instanceof PlayerHCF) {
        $player->sendMessage("te uniste a la faction");
      }
    } 
  }
  
  public function deleteFaction(string $name): void
  {
    if (!$this->isFaction($name)) {
      return;
    }
    $faction = $this->factions[$name];
    foreach($faction->getMembers() as $player) {
      $player->setFaction(null);
      $player->setFactionRank(null);
    }
    //code... SQLite3
    unset($faction);
  }
  
  public function getLeader(string $username): bool
  {
    $player = Server::getInstance()->getPlayerByPrefix($player);
    return ($player->getFactionRank() === $query["factionRank"]);
  }
  
}
