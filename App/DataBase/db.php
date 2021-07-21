<?php

// namespace App\DataBase ;
// use pdo ;
// use PdoException ;

class db {
    
    private $con    ;
    private $host   = "localhost";
    private $dbname = "mytodolist";
    private $user   = "root";
    private $pass   = ""; 


    public function connection()
    {
        try {
          $this->con = new \PDO("mysql:dbname=$this->dbname;host=$this->host",$this->user,$this->pass);
           echo "OK" . PHP_EOL;
        } catch (\PdoException $e) {
            die ("Connection Failed : " . $e->getMessage() );
        }
    }
}

