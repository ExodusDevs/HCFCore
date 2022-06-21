<?php

namespace hcf\util;

use pocketmine\math\Vector3;
use pocketmine\entity\Location;
use pocketmine\Server;

class Math
{
  
  public static function inRegion(Vector3 $playerPosition, Vector3 $position1, Vector3 $position2): bool
  {
    $minX = min($position1->x, $position2->x);
    $minZ = min($position1->z, $position2->z);
    $maxX = max($position1->x, $position2->x);
    $maxZ = max($position1->z, $position2->z);
    return $playerPosition->x >= $minX && $playerPosition->x <= $maxX && $playerPosition->z >= $minZ && $playerPosition->z <= $maxZ;
  }
  
  public static function searchPlayersInDistance(Vector3 $pos, int $distance): array
  {
    $players = [];
    foreach(Server::getInstance()->getOnlinePlayers() as $player) {
      if ($position->distance($player->getPosition()) <= $distance) {
        array_push($players, $player);
      } 
    }
  }
  
  public static function vector3ToArray(Vector3 $location): array
  {
    return $location instanceof Location ? [$location->x, $location->y, $location->z, $location->yaw, $location->pitch] : [$location->x, $location->y, $location->z];
  }
  
  /**
   * @param array(X, Y, X)
   **/
  public static function arrayToVector3(array $coords): Vector3
  {
    return new Vector3($coords[0], $coords[1], $ccords[2]);
  }
  
  public static function arrayToLocation(array $coords): Location
  {
    return new Location($cords[0], $coords[1], $coords[2], Server::getInstance()->getWorldManager()->getDefaultWorld(), $coords[3], $coords[4]);
  }
  
}
