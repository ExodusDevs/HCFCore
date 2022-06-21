<?php

namespace hcf\rank;

use hcf\Loader;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\Config;

class Rank {



    public static array $ranks = [
        "owner" => [
            "format_chat" => "",
            "format_tag" => "",
            "permissions" => []
        ],
        "co_owner" => [
            "format_chat" => "",
            "format_tag" => "",
            "permissions" => []
        ],
        "default" => [
            "format_chat" => "",
            "format_tag" => "",
            "permissions" => []
        ]
    ];

    public static function getTag(string $name) : string {
        $config = new Config(Loader::getInstance()->getDataFolder()."players/".$name.".json", Config::JSON);
        return self::$ranks[$config->get("rank")]["format_tag"];
    }

    public static function getChat(string $name) : string {
        $config = new Config(Loader::getInstance()->getDataFolder()."players/".$name.".json", Config::JSON);
        return self::$ranks[$config->get("rank")]["format_chat"];
    }

    public static function getRank(string $name) : string {
        $config = new Config(Loader::getInstance()->getDataFolder()."players/".$name.".json", Config::JSON);
       return self::$ranks[$config->get("rank")];
       
    }


    public static function getPermissions(string $name) : string|array {
        $config = new Config(Loader::getInstance()->getDataFolder()."players/".$name.".json", Config::JSON);
        return self::$ranks[$config->get("rank")]["permissions"];
    }

    public static function setRank(string $name, string $rank) {
        $config = new Config(Loader::getInstance()->getDataFolder()."players/".$name.".json", Config::JSON);
        $config->set("rank", $rank);
        $config->save();
    }

}
