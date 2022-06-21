<?php

namespace hcf\manager;

use hcf\Loader;
use hcf\kit\{
  Kit,
  KitException
};

use pocketmine\item\Item;
use pocketmine\utils\{
  Config,
  SingletonTrait
};

class KitManager 
{
  use SingletonTrait;
  
  /** @var Kit[] */
  protected array $kits = [];
  
  /** Receive the items, to add them later to the GUI **/
  public static function init(): void
  {
    foreach(glob(Loader::getInstance()->getDataFolder() . "kits" . DIRECTORY_SEPARATOR . "*.yml") as $kit) {
      if (!is_file($kit)) {
        return;
      }
      $dataObject = (new Config($kit, Config::YAML))->getAll();
      if (empty($dataObject["items"]) && empty($dataObject["armor"])) {
        throw new KitException('Kit data is not defined {$dataObject["name"]}');
      }
      foreach($dataObject["items"] as $slot => $value) { 
        $dataObject["items"][$slot] = Item::jsonDeserialize($value);
      }
      foreach($dataObject["armor"] as $slot => $value) {
        $dataObject["armor"][$slot] = Item::jsonDeserialize($value);
      }
      $dataObject["itemPresent"] = ($dataObject["itemPresent"] === null) ? [] : Item::jsonDeserialize($dataObject["itemPresent"]);
      $this->createKit($dataObject["id"], $dataObject);
    }
  }
  
  public function createKit(int $kitId, array $kitData): void
  {
    if (empty($kitData)) {
      throw new KitException("Kit name is null or not defined");
    }
    $this->kits[$kitId] = new Kit($kitId, $kitData["name"], $kitData["permission"], $kitData["cooldown"], $kitData["customName"], $kitData["items"], $kitData["armor"], $kitData["itemPresent"]);
  }
  
  public function saveKit(?Kit $kit): void
  {
    if (empty($kit)) {
      throw new KitException("");
    }
    $config = new Config(Loader::getInstance()->getDataFolder() . "kits" . DIRECTORY_SEPARATOR . $kit->getName() . ".yml", Config::YAML);
    $config->setAll($kit->toArray());
    $config->save();
  }
  
  public function deleteKit(int $id): void
  {
    $kit = $this->kits[$id];
    if (empty($kit)) return;
    if (is_file(Loader::getInstance()->getDataFolder() . "kits" . DIRECTORY_SEPARATOR . $kit->getName() . ".yml")) {
      unlink(Loader::getInstance()->getDataFolder() . "kits" . DIRECTORY_SEPARATOR . $kit->getName() . ".yml");
    }
    unset($kit);
  }
  
  public function isKit(int $id): bool 
  {
    return $this->kits[$id] !== null ? true : false;
  }
  
  public function getKit(int $id): ?Kit 
  {
    return $this->kits[$id] ?? null; 
  }
  
  public function getKits(): array
  {
    return $this->kits;
  }
  
}