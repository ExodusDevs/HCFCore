<?php

namespace hcf\command;

use pocketmine\command\{
  Command,
  CommandSender,
  utils\InvalidCommandSyntaxException
};
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;

use hcf\command\{
  SubCommand,
  sub\RegionCreateSubCommand,
  sub\RegionListSubCommand,
  sub\RegionEditSubCommand
};

class RegionCommand extends Command
{
  private array $subCommands = [];
  
  public function __construct()
  {
    parent::__construct("region", "Region Command", "/region <create|edit|list>", ["r"]);
    $this->setPermission("region.command");
    $this->addSubCommand(new RegionCreateSubCommand());
    $this->addSubCommand(new RegionEditSubCommand());
    $this->addSubCommand(new RegionListSubCommand());
    //$this->addSubCommand(new RegionDeleteSubCommand());
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if (!$sender instanceof Player) {
      throw new InvalidCommandSyntaxException();
    }
    if (count($args) === 0) {
      throw new InvalidCommandSyntaxException();
    }
    if (isset($args[0])) {
      $subCommand = $this->getSubCommand($args[0]);
      if ($subCommand !== null) {
        $subCommand->execute($sender, $label, $args);
      } else {
        $messages = [
          TextFormat::GRAY . "/{$label} create " . TextFormat::GREEN . "» " . TextFormat::RESET . "Crea la region en un mapa especifico",
          TextFormat::GRAY . "/{$label} edit " . TextFormat::GREEN . "» " . TextFormat::RESET . "Edita la region con el nombre establecido anteriormente",
          TextFormat::GRAY . "/{$label} list " . TextFormat::GREEN . "» " . TextFormat::RESET . "Lista de regiones que has creado actualmente"
          //TextFormat::GRAY . "/{$label} delete " . TextFormat::GREEN . "» " . TextFormat::RESET . "Elimina la region que has creado"
        ];
        $sender->sendMessage(implode("\n", $messages));
      }
    }
  }
  
  public function addSubCommand(SubCommand $subCommand): void
  {
    $this->subCommands[$subCommand->getName()] = $subCommand;
  }
  
  public function getSubCommand(string $commandName): ?SubCommand
  {
    if (!empty($command = $this->subCommands[$subCommand])) {
      return $command;
    }
    return null;
  }
  
}
