<?php
    class Connection
    {
        private static $connection;

        private function __construct()
        {}
    
        public static function getInstance()
        {
            $host= "mysql:host=localhost;dbname=task_list";
			$user= "root";
            $pass= "";
            
            if (is_null(self::$connection)) {
                self::$connection = new \PDO($host, $user, $pass);
                self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$connection->exec('set names utf8');
            }
            return self::$connection;
        }
    }