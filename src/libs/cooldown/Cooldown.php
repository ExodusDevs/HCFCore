<?php

namespace libs\cooldown;

use Closure;

class Cooldown
{
  protected string $name;
  
  protected int $duration;
  
  protected Closure $inCooldown;
  
  public function __construct(string $name, int $duration, Closure $inCooldown)
  {
    $this->name = $name;
    $this->duration = $duration;
    $this->inCooldown = $inCooldown;
  }
  
  public function getName(): string
  {
    return $this->name;
  }
  
  public function getDuration(): int
  {
    return $this->duration;
  }
  
  public function getInCooldown(): Closure
  {
    return $this->inCooldown;
  }
  
}