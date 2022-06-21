<?php

namespace hcf\command;

use pocketmine\command\{
  Command,
  CommandSender
};
use pocketmine\utils\TextFormat;
use pocketmine\player\Player;
use pocketmine\nbt\tag\IntTag;

use hcf\command\{
  SubCommand,
  sub\KitCreateSubCommand,
  sub\KitSetSubCommand
};
use hcf\kit\Kit;
use hcf\manager\KitManager;

//lib: InvMenu
use libs\invmenu\{
  InvMenu,
  transaction\DeterministicInvMenuTransaction
};

class KitCommand extends Command
{
  protected array $commands;
  
  public function __construct()
  {
    parent::__construct("gkit", "null", "/gkit");
    $this->addCommand();
  }
  
  public function execute(CommandSender $sender, string $label, array $args): void
  {
    if (!$sender instanceof Player) {
      return;
    }
    if (!isset($args[0])) {
      $menu = InvMenu::create(InvMenu::TYPE_CHEST);
      $menu->setName(TextFormat::colorize("&l&bGkit GUI"));
      foreach(KitManager::getInstance()->getKits() as $kit) {
        $menu->getInventory()->addItem($kit->getItemPresent());
      }
      $menu->setListener(InvMenu::readonly(function(DeterministicInvMenuTransaction $transaction) : void {
        $player = $transaction->getPlayer();
        $itemClicked = $transaction->getItemClicked();
        if ($itemClicked->getNamedTag()->getTag("kitId") instanceof IntTag) {
          $kit = KitManager::getInstance()->getKit(($itemClicked->getNamedTag()->getTag("kitId"))->getValue());
          if (!$player->hasPermission($kit->getPermission())) {
            $player->sendMessage("no permission");
            $player->removeCurrentWindow();
            return;
          }
          if (isset($player->getCooldown()->get("kit-cooldown")) && ($player->getCooldown()->get("kit-cooldown")->getDuration() - time()) <= 0) {
            foreach($kit->getItems() as $slot => $item) {
              if ($player->getInventory()->canAddItem($item)) {
                $player->getInventory()->setItem($slot, $item);
              } else {
                $player->getWorld()->dropItem($player->getPosition(), $item, $player->getLocation());
              }
            }
            foreach($kit->getArmors() as $slot => $item) {
              if ($player->getInventory()->canAddItem($item)) {
                $player->getInventory()->setItem($slot, $item);
              } else {
                $player->getWorld()->dropItem($player->getPosition(), $item, $player->getLocation());
              }
            }
          $player->sendMessage("has recibido el kit: " . $kit->getCustomName());
          $player->removeCurrentWindow();
          } else {
            $player->getCooldown()->set("kit-cooldown", time() + $kit->getCooldown(), function(int $cooldown) use($player): void {
              $player->sendMessage("tienes un cooldown de: " . $cooldown);
            });
          }
        }
      }));
      $menu->send($sender);
    } else {
      $command = $this->commands[$args[0]];
      if ($sender->hasPermission($command->getPermission())) {
        $command->execute($sender, $label, $args);
      }
    }
  }
  
  public function addCommand(SubCommand $subCommand): void
  {
    $this->commands[$subCommand->getName()] = $subCommand;
  }
  
}