<?php

namespace hcf\fight\logger;

use hcf\Loader;
use hcf\player\PlayerHCF;
use hcf\translation\Translation;

use pocketmine\entity\{Entity,Zombie};
use pocketmine\utils\TextFormat as Text;
use pocketmine\item\Item;
use pocketmine\event\entity\{EntityDamageEvent, EntityDamageByEntityEvent};
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\math\Vector3;

class LogoutZombie extends Zombie 
{
  public PlayerHCF $player;
  
  public string $name;
  
  public int $timeLeft; 
    
  public array $items;
  
  public array $armorItems;
  
  public function __construct(Location $location, ?CompoundTag $nbt = null)
  {
    parent::__construct($location, $nbt);
    //$this->setMaxHealth(100);
  }
  
  public function setPlayer(PlayerHCF $player): void
  {
    $this->player = $player;
    $thid->name = $player->getName();
  }
  
  public function setTime(int $value): void
  {
    $this->timeLeft = $value;
  }
  
  public function setItems(array $items): void
  {
    $this->items = $items;
  }
  
  public function setArmors(array $armor): void
  {
    $this->armorItems = $armor;
  }
  
  public function onUpdate(int $currentTick): bool
  {
    if (count(Loader::getInstance()->getServer()->getOnlinePlayers()) === 0) {
      $this->close();
      return false;
    }
    if ($this->timeLeft === 0) {
      $this->close();
      return false;
    }
    if ($this->player === null && $this->name === null) {
      $this->close();
      return false;
    }
    if ($this->player !== Loader::getInstance()->getServer()->getPlayerByPrefix($this->name) && $this->name !== $this->player->getName()) {
      $this->close();
      return false;
    }
    $this->timeLeft--;
    $this->setNameTag(
      Translation::addMessage("fight-logger-logout", ["&" => "§", "name" => $this->name])
    );
    $this->setScoreTag(
      Translation::addMessage("fight-logger-logout-time", ["&" => "§", "time" => $this->timeLeft])
    );
    $this->setNameTagVisible(true);
    return parent::onUpdate($currentTick);
  }
  
  public function getDrops(): array
  {
    $items = array_merge(
      $this->items === null ? [] : array_values($this->items),
      $this->armor === null ? [] : array_values($this->armorItems)
    );
    return $items;
  }
  
}
