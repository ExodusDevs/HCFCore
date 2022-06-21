<?php

namespace hcf\manager;

use pocketmine\utils\{
  Config,
  SingletonTrait
};
use pocketmine\world\Position;

use hcf\crate\Crate;
use hcf\Loader;

class CrateManager
{
  use SingletonTrait;
  
  /** @var Crate[] **/
  private array $crates = [];
  
  public static function init(): void
  {
    foreach(glob(Loader::getInstance()->getDataFolder() . "crates" . DIRECTORY_SEPARATOR . "*.yml") as $crate) {
      $config = new Config($crate, Config::JSON);
      $this->createCrate(new Crate($config->get("name"), $config->get("customName"), $config->get("rewards"), $config->get("blockId"), $config->get("position")));
    }
  }
  
  public function getCrates(): array
  {
    return $this->crates;
  }
  
  public function getCrate(string $name): ?Crate
  {
    return ($crate = $this->crates[$name]) instanceof Crate ? $crate : null;
  }
  
  public function createCrate(Crate $crate): void
  {
    $this->crates[$crate->getName()] = $crate;
  }
  
  public function saveCrate(string $name): void
  {
    $crate = $this->getCrate($name);
    $config = new Config(Loader::getInstance()->getDataFolder() . "crates" . DIRECTORY_SEPARATOR . $crate->getName() . ".json", Config::JSON);
    $config->setAll($crate->toArray());
    $config->save();
  }
  
  public function deleteCrate(string $name): void
  {
    unset($this->crates[$name]);
    if (is_file($folder = Loader::getInstance()->getDataFolder() . "crates" . DIRECTORY_SEPARATOR . $name . ".json")) {
      unlink($folder);
    }
  }
  
}
