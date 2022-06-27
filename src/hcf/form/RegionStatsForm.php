<?php

namespace hcf\form;

use libs\formapi\MenuForm;

use pocketmine\player\Player;

class RegionStatsForm extends MenuForm
{
  
  public function __construct(string $stats)
  {
    parent::__construct("Region Stats", $stats, [], null, null);
  }
  
}