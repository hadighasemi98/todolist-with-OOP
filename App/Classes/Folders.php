<?php
namespace App\Classes;

class Folders extends BaseModel
{

    protected $table = "folders"  ;
    // protected $key   = $_GET['folder_id'] ;

    //OverRidding
    public function selectQuery()
    {        
        $sql   = "SELECT * FROM {$this->table}  ";
        $query = $this->con->prepare($sql);
        $query->execute();
        $row = $query->fetchAll(\PDO::FETCH_OBJ);
        return $row ;
    }

    public function insertQuery()
    {
        
        $sql   = "INSERT INTO `$this->table` (`name`,`user_id`) VALUES (:name,:user_id) ";
        $query = $this->con->prepare($sql);
        $query->execute([':name'=>$_POST['folderName'],':user_id'=>1]);
        // $row = $query->rowCount();
        // return $row;
            
        }

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



