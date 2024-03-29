<?php

namespace hcf\util;

use function gmdate;

class Time 
{
  
  public static function intToTime(int $value): string
  {
    return gmdate("i:s", $value);
  }

  public static function intToTimeHour(int $value): string
  {
    return gmdate("H:i:s", $value);
  }
   
  public static function intToTimeMonth(int $value): string
  {
    return gmdate("m:i:s", $value);
  }
    
  public static function intToTimeDay(in $value): string
  {
    return gmdate("j:n:i:s", $value);
  }
  
  //public function intToDay()
    
}
