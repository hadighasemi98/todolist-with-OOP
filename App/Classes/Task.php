<?php
namespace App\Classes;
class Task extends BaseModel
{
    # Properties
    protected $table = "task"  ;
    protected $key = "status=1-status"  ; // Dynamic Update Switch

    private $where ;
    private $limit ;
    private $start ;
    private $page  ;
    private $pageSize ;

    # Method
    # OverRidding
    public function selectQuery()
    {
        $this->limit    ='LIMIT 7';
        $this->page     = $_POST['page']      ?? null ;
        $this->pageSize = $_POST['page_size'] ?? null ;

        // Select Folder
        !empty($_POST['folderId']) ? $this->where = "WHERE folder_id = $_POST[folderId]" : null ;   

        // Get Done Or Pending Task
        $_POST['pending'] ? $this->where="WHERE status = 0" : ($_POST['done'] ? $this->where="WHERE status = 1" : null);
        
        // Pagination
        if(($_POST['page'] ?? null) && ($_POST['page_size']))
        {
            $this->start = ($this->page-1 ) * ($this->pageSize) ;
            $this->limit = "LIMIT $this->start,$this->pageSize ";
        }
        
        # Query to DB
        $sql   = "SELECT * FROM {$this->table} {$this->where}  order by `created_at` desc {$this->limit} ";
        $query = $this->con->prepare($sql);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);        
    }

    # OverRidding
    public function insertQuery()
    {
        $sql   = "INSERT INTO {$this->table} (`name`,`folder_id`) VALUES (:name,:folder_id ) ";
        $query = $this->con->prepare($sql);
        $query->execute([':name'=>$_POST['TaskName'],':folder_id'=>$_POST['folderId']]);
        // $row = $query->rowCount();
        // return $row;
    }

}



