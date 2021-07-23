<?php
namespace App\Classes;
abstract class BaseModel {

    private   $host   = "localhost";
    private   $dbname = "mytodolist";
    private   $user   = "root";
    private   $pass   = ""; 
    protected $con ;

    # Connection
    public function __construct()
    {
        try {
          $this->con = new \PDO("mysql:dbname=$this->dbname;host=$this->host",$this->user,$this->pass);
        //    echo "OK" . PHP_EOL;
        } catch (\PdoException $e) {
            die ("Connection Failed : " . $e->getMessage() );
        }
    }

    #Abstract method
    public abstract function selectQuery();
        
    public abstract function insertQuery();
    
    public abstract function deleteQuery($id);
        
    public abstract function updateQuery($id);
        
 }

