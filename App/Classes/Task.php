<?php
namespace App\Classes;

class Task extends BaseModel
{
    // Properties
    protected $table = "task"  ;
    protected $key = "status=1-status"  ; // Dynamic Update Switch

    private $where ;
    private $limit ;
    private $start ;
    private $page  ;
    private $pageSize ;
    
    // Method
    //OverRidding
    public function selectQuery()
    {
        // $this->where ='';
        $this->limit ='LIMIT 7';
        $this->page     = $_POST['page']      ?? null ;
        $this->pageSize = $_POST['page_size'] ?? null ;

        // Select Folder
        if($_POST['folderId'] ?? null)
        {
            $this->where = "WHERE folder_id = $_POST[folderId]";
        }

        // Get Done Or Pending Task
        if( ($_POST['pending'] ?? null) || ($_POST['done'] ?? null ) )
        {
            $this->where = $_POST['pending'] ? "WHERE status = 0" : "WHERE status = 1 ";
        }
        
        // Search
        // if(isset($_POST['sub']) )
        // {
        //     // echo $_POST['searchInput'];
        //      $this->where = "WHERE name LIKE 1 ";
        // }

        // Pagination
        if(($_POST['page'] ?? null) && ($_POST['page_size']))
        {
            $this->start = ($this->page-1 ) * ($this->pageSize) ;
            $this->limit = "LIMIT $this->start,$this->pageSize ";
        }

        
        // Query
        $sql   = "SELECT * FROM {$this->table} {$this->where}  order by `created_at` desc {$this->limit} ";
        $query = $this->con->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);        
    }

    //OverRidding
    public function insertQuery()
    {
        $sql   = "INSERT INTO {$this->table} (`name`,`folder_id`) VALUES (:name,:folder_id ) ";
        $query = $this->con->prepare($sql);
        $query->execute([':name'=>$_POST['TaskName'],':folder_id'=>$_POST['folderId']]);
        $row = $query->rowCount();
        return $row;
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



