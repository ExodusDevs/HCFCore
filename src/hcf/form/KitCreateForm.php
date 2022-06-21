<?php

namespace hcf\form;

use libs\formapi\{
  BaseForm,
  CustomForm,
  CustomFormResponse,
  element\Label,
  element\Input,
  element\Dropdown
};

class KitCreateForm extends CustomForm
{
  
  public function __construct()
  {
    parent::__construct("Kit Create", [
      new Label("info", "§7"),
      new Label("helpId", "??"),
      new Input("id", "§oThis must be a number, you identify the Kit that you have added and then obtain them whenever you want", "", "0-50"),
      new Label("help", "???"),
      new Input("name", "§oKit name, helps to better identify which kit it is", "", "Atomo"),
      new Label("help1", "??"),
      new Input("customName", "§oWrite a custom name, it must contain & and not §, PS: it will appear every time you equip the kit, and in the items", "", "&bAto&6mo"),
      new Label("help2", "???"),
      new Input("permission", "§oType the permission you want players to get the kit", "", "kit.test.permission"),
      new Label("help3", "???"),
      new Dropdown("cooldown", "§oCooldown", [
        "60",
        "120",
        "360"
      ], 1),
      new Label("help3", "???"),
      new Input("itemPresent", "§oThis should be set as the id of the item that represents your kit", "", "245:0")
    ], function(Player $player, CustomFormResponse $data): void {
      $id = $data->getInt("id");
      $name = $data->getString("name");
      $customName = $data->getString("customName");
      $permission = $data->getString("permission");
      $cooldown = $data->getInt("cooldown");
      $items = [];
      $armor = [];
      $itemPresent = $data->getString("itemPresent");
      if (empty($id) || empty($name) || empty($customName) || empty($cooldown) || empty($itemPresent)) {
        return;
      }
      foreach($player->getInventory()->getContents(true) as $slot => $item) {
        $items[$slot] = $item->jsonSerialize();
      }
      foreach($player->getArmorInventory()->getContents(true) as $slot => $item) {
        $armor[$slot] = $item->jsonSerialize();
      }
      KitManager::getInstance()->createKit($id, [$id, $name, $permission, $cooldown, $customName, $items, $armor, $itemPresent]);
      KitManager::getInstance()->saveKit(KitManager::getInstance()->getKit($id));
      $player->sendMessage("kit creado correctamente");
    });
  }
  
}
