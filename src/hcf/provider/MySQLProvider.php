<?php

namespace hcf\provider;

use PDO;

use hcf\Loader;

class MySQLProvider
{
  private PDO $database;
  
  public function __construct(Loader $core)
  {
    $core->saveDefaultConfig();
    $host = (string)$core->getConfig()->getNested("mysql")["host"];
    $dbname = (string)$core->getConfig()->getNested("mysql")["name"];
    $port = (int)$core->getConfig()->getNested("mysql")["port"];
    $user = (string)$core->getConfig()->getNested("mysql")["user"];
    $password = (string)$core->getConfig()->getNested("mysql")["pass"];
    $this->database = new PDO("mysql:host={$host};dbname={$dbname};charset=UTF8;port={$port}", $user, $password);
    $this->database->exec("CREATE TABLE IF NOT EXISTS players(uuid VARCHAR(50) PRIMARY KEY, username VARCHAR(15), rank TINYTEXT DEFAULT NULL, factionName VARCHAR(15) DEFAULT NULL, factionRank TINYTEXT DEFAULT NULL, tags VARCHAR(250) DEFAULT '', money BIGINT DEFAULT 0, murders INT DEFAULT 0, deaths INT DEFAULT 0, reclaim TINYINT DEFAULT 0)");
    $this->database->exec("CREATE TABLE IF NOT EXISTS factions(name VARCHAR(35) DEFAULT NULL, members VARCHAR(100), money BIGINT DEFAULT 0 NOT NULL, dtr DOUBLE DEFAULT 0 NOT NULL)");
    $core->getLogger()->notice("[Provider: MySQL] successfully activated");
  }
  
  public function getDatabase(): PDO
  {
    return $this->database;
  }
  
  public function destruct(): void
  {
    $this->database = null;
  }
  
}