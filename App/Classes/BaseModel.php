<?php
namespace App\Classes;
// use App\DataBase\db;

abstract class BaseModel {

    private   $host   = "localhost";
    private   $dbname = "mytodolist";
    private   $user   = "root";
    private   $pass   = ""; 
    protected $con ;

    public function __construct()
    {
        try {
          $this->con = new \PDO("mysql:dbname=$this->dbname;host=$this->host",$this->user,$this->pass);
        //    echo "OK" . PHP_EOL;
        } catch (\PdoException $e) {
            die ("Connection Failed : " . $e->getMessage() );
        }
    }
    
    // public function connect()
    // {
    //     $this->con = new db() ;
    //     $this->dbObj = $this->con->connection() ;
    // }

//     protected $table  ;
//     protected $key  ;
//     protected $data  ;


//     public function selectQuery()
//     {        
//         $sql   = "SELECT * FROM {$this->table}  ";
//         $query = $this->con->prepare($sql);
//         $query->execute();
//         $row = $query->fetchAll(\PDO::FETCH_OBJ);
//         return $row ;
//     }
    
        
//     public abstract function insertQuery();
        
    


    

 }

