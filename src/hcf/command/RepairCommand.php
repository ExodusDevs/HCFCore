<?php

namespace hcf\commands;

use hcf\HCF;
use hcf\player\PlayerHCF;

use pocketmine\item\{Item, Armor, Tool};

use pocketmine\utils\TextFormat;
use pocketmine\command\{CommandSender, Command};

class RepairCommand extends Command 
{
	
	/**
	 * RepairCommand Constructor.
	 */
	public function __construct()
	{
		parent::__construct("fix", "Can repair the items in your Inventory", "/fix all");
		parent::setPermission("fixall.use");
	}
	
	/** 
	 * Luego lo sigo si alguien quiere seguirlo no problemaxd 
	 */
	public function execute(CommandSender $sender, string $label, array $args): void {
	  if (!$sender instanceof PlayerHCF) {
	    return;
	  }
		if (empty($args)) {
		  $sender->sendMessage(TextFormat::RED . "Argument #1 is not valid for command syntax");
      return;
		}
		if ($args[0] === "all") {
		  
		}
	}
	
}