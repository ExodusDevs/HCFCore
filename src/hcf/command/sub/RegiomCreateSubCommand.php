<?php

namespace hcf\command\sub;

use hcf\command\SubCommand;
use hcf\Loader;
use hcf\form\RegionCreateForm;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;

class RegionCreateSubCommand extends SubCommand
{
  
  public function __construct()
  {
    parent::__construct("create", "Crea la region en un mapa especifico", "/region create <form: name|world>");
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    $sender->sendForm(new RegionCreateForm());
  }
  
}
