<?php

namespace hcf\crate;

use pocketmine\iten\Item;
use pocketmine\math\Vector3;

use hcf\util\Math;

class Crate
{
  use Math;
  
  private string $name;
  
  private string $customName;
  
  /** @var Item[] **/
  private array $rewards;
  
  /** @var String "241:0" **/
  private string $blockId;

  /** @var Position **/
  private array $position;
  
  public function __construct(string $name, string $customName, array $rewards, string $blockId, array $position)
  {
    $this->name = $name;
    $this->customName = str_replace("&", "§", $customName);
    foreach($rewards as $item) {
      $this->rewards[] = Item:: jsonDeserialize($item);
    }
    $this->blockId = $blockId;
    $this->position = new Vector3($position["x"], $position["y"], $position["z"]);
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getCustomName(): string
  {
    return $this->customName;
  }
  
  public function setCustomName(string $customName): void
  {
    $this->customName = $customName;
  }
  
  public function getRewards(): array
  {
    return $this->rewards;
  }
  
  public function setRewards(array $rewards): void
  {
    $this->rewards = $rewards;
  }
  
  public function getBlockId(): string
  {
    return $this->blockId;
  }
  
  public function getPosition(): Position
  {
    return $this->position;
  }
  
  public function setPosition(Position $position): void
  {
    $this->position = $position;
  }
  
  public function isYourBlock(string $blockId = "0:0"): bool
  {
    return $this->getBlockId() === $blockId ? true : false;
  }
  
  public function toArray(): array
  {
    $rewards = [];
    foreach($this->getRewards() as $item) {
      $rewards[] = $item->jsonSerialize();
    }
    $position = $this->vector3ToArray($this->getPosition());
    return [
      "name" => $this->getName(),
      "customName" => $this->getCustomName(),
      "blockId" => $this->getBlockId(),
      "rewards" => $rewards,
      "position" => $position
    ];
  }
  
}
