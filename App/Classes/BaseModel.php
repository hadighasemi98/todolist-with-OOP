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

    
    # Abstract method - For Open Close principle - With Polymorphism low
    public abstract function selectQuery();
        
    public abstract function insertQuery();

    # Reuseable Method 
    public function deleteQuery($id)
    {            
        $sql   = "DELETE FROM `$this->table` WHERE id =:id ";
        $query =  $this->con->prepare($sql);
        $query->execute([':id'=>$id]);
        $row = $query->rowCount();
        return $row;
    }

    public function updateQuery($id)
        {
            $sql   = "UPDATE {$this->table} SET {$this->key} WHERE id =:id";
            $query = $this->con->prepare($sql);
            $query->execute([':id'=>$id]);
            $row = $query->rowCount();
            return $row;
        }

        
 }

