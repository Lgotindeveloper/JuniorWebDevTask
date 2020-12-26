<?php


class Db
{
    public static function getConnection()
    {
        //Это на будущее, если сменится с sqlite3 на mysql и тд, а я думаю сменится 100% :)
        /*
        $paramsPath = ROOT . "/config/dbParams.php";
        $params = include($paramsPath);

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $pdo = new PDO($dsn, $params['user'], $params['password']);
        */

        //Т.к пока что у нас в проекте sqlite3, возвращаю подключение к sqlite3
        $pdo = new PDO('sqlite:db.sqlite3');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec('
CREATE TABLE IF NOT EXISTS users (
  uuid VARCHAR(255) NOT NULL,
  first_name VARCHAR(255) NOT NULL,
  last_name VARCHAR(255) NOT NULL,
  phone VARCHAR(255) DEFAULT NULL,
  email VARCHAR(255) DEFAULT NULL,
  address TEXT NOT NULL,
  registered_at DATETIME NOT NULL,
  PRIMARY KEY (uuid)
)
');

        return $pdo;
    }
}