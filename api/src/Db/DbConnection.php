<?php

namespace App\Db;

use Symfony\Component\Yaml\Yaml;

Class DbConnection
{
    private static $instance = null;

    /** @var PDO */
    private $pdo;

    /**
     * DbConnection constructor.
     */
    private function __construct() {
        try {
            $mysqlConfig = Yaml::parseFile(__DIR__.'/../../config/config.yml')['mysql'];
            $this->pdo = new \PDO(
                "mysql:host=".$mysqlConfig['host'].";port=".$mysqlConfig['port'].";dbname=".$mysqlConfig['database'],
                $mysqlConfig['user'],
                $mysqlConfig['password']
            );
        } catch (\PDOException $e) {
            die($e->getMessage());
        }

    }

    /**
     * @return DbConnection
     */
    public static function getInstance(): DbConnection {
        if (is_null(self::$instance)) {
            self::$instance = new DbConnection();
        }

        return self::$instance;
    }

    /**
     * @return \PDO
     */
    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}