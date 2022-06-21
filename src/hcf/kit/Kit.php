<?php

namespace hcf\kit;

use pocketmine\item\Item;

class Kit
{
  private int $id;
  
  private string $name;
  
  private string $permission;
 
  private int $cooldown;
  
  private string $customName;
  
  private array $items;
  
  private array $armor;
  
  private array $itemPresent;
  
  public function __construct(int $id, string $name, string $permission, int $cooldown, string $customName, array $items, array $armor, array $itemPresent)
  {
    $this->id = $id;
    $this->name = $name;
    $this->permission = $permission;
    $this->cooldown = $cooldown;
    $this->customName = str_replace("&", "§", $customName);
    foreach($items as $slot => $data) {
      $this->items[$slot] = Item::jsonDeserialize($data);
    }
    foreach($armor as $slot => $data) {
      $this->armor[$slot] = Item::jsonDeserialize($data);
    }
    $this->itemPresent = Item::jsonDeserialize($itemPresent);
    $this->itemPresent->getNamedTag()->setInt("kitId", $id);
  }
  
  public function getId(): int
  {
    return $this->id;
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getPermission(): string
  {
    return $this->permission;
  }
  
  public function getCooldown(): int
  {
    return $this->cooldown;
  }
  
  public function getCustomName(): string
  {
    return $this->customName;
  }
  
  public function getItems(): array
  {
    return $this->items;
  }
  
  public function getArmors(): array
  {
    return $this->armor;
  }
  
  public function getItemPresent(): Item
  {
    return $this->itemPresent;
  }
  
  public function toArray(): array
  {
    $items = [];
    $armors = [];
    foreach($this->getItems() as $slot => $item) {
      $items[$slot] = $item->jsonSerialize();
    }
    foreach($this->getArmors() as $slot => $item) {
      $armors[$slot] = $item->jsonSerialize();
    }
    return [
      "id" => $this->getId(),
      "name" => $this->getName(),
      "permission" => $this->getPermission(),
      "cooldown" => $this->getCooldown(),
      "customName" => $this->getCustomName(),
      "items" => $items,
      "armor" => $armors,
      "itemPresent" => $this->getItemPresent()->jsonSerialize()
    ];
  }
}
