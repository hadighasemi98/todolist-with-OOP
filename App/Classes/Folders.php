<?php
namespace App\Classes;

class Folders extends BaseModel
{

    # Properties
    protected $table = "folders"  ;

    # OverRidding
    public function selectQuery()
    {        
        $sql   = "SELECT * FROM {$this->table}  ";
        $query = $this->con->prepare($sql);
        $query->execute();
        $row = $query->fetchAll(\PDO::FETCH_OBJ);
        return $row ;
    }

    # OverRidding
    public function insertQuery()
    {
        $sql   = "INSERT INTO `$this->table` (`name`,`user_id`) VALUES (:name,:user_id) ";
        $query = $this->con->prepare($sql);
        $query->execute([':name'=>$_POST['folderName'],':user_id'=>1]);            
    }

}



