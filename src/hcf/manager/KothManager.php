<?php

namespace hcf\manager;

use hcf\event\koth\Koth;
use hcf\task\koth\KothTask;
use hcf\Loader;

class KothManager
{
  /** @var Koth[] **/
  private array $koths = [];
  
  /** @var Loader **/
  private Loader $core;
  
  public function __construct(Loader $core)
  {
    $this->core = $core;
  }
  
  public function getKoths(): array
  {
    return $this->koths;
  }
  
  public function createKoth(?Koth $koth): void
  {
    if ($koth === null) return;
    $this->koths[$koth->getName()] = $koth;
  }
  
  public function startGame(): void
  {
    if (empty($this->koths)) {
      return;
    }
  }
  
  public function endGame(): void
  {
    if (empty($this->koths)) {
      return;
    }
  }
  
}