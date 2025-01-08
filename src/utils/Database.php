<?php

namespace App\Utils;

use PDO;

class Database
{
    private $pdo;

    public function __construct()
    {
        $configData = parse_ini_file(__DIR__ . '/../config.ini');
        $this->pdo = new PDO('pgsql:host=' . $configData['DB_HOST'] . ';dbname=' . $configData['DB_NAME'], $configData['DB_USERNAME'], $configData['DB_PASSWORD'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($sql, $params = [])
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return $query->fetchAll();
    }

    public function queryOne($sql, $params = [])
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($params);
        return $query->fetch();
    }

    public function executeSql($sql, $params = [])
    {
        $query = $this->pdo->prepare($sql);
        return $query->execute($params);
    }
}