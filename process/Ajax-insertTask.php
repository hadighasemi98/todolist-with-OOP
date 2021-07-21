<?php
include '../autoLoad.php';

use App\Classes\Folders;
use App\Classes\Task;

$Tasks = new Task();
$Folders = new Folders();

if(isset($_POST['action']) && $_POST['action'] == 'viewFolders'  )
{

      if(!$Folders->selectQuery() < 1 ){ 
           foreach ($Folders->selectQuery() as $folder) : 
           echo "
           <li class= ''  >
           <a href='?folder_id=$folder->id'>
           <i class='fa fa-folder'></i>
              <span>$folder->name </span>
                <a href='' class='remove' id='$folder->id' onclick='return confirm(Are You sure to Delete This Item ?);'> x </a>
            </li>
            </a>";
           endforeach; 

           }else{echo ' There is no Folder here ... ';} 

           // Get Done Tasks or Pending Tasks
           
}

if (isset($_POST['action']) && $_POST['action'] == 'viewTasks') {
     
    if (!$Tasks->selectQuery() < 1) {
        foreach ($Tasks->selectQuery() as $task) :
          echo"<li class=";
          echo $task->status>0 ? 'checked' : '';
          echo"><i class='clickable isDone ";
          echo $task->status>0 ? 'fa fa-check-square-o' : 'fa fa-square-o' ;
          echo "'data-taskId='$task->id'></i>
          <span>$task->name </span>
          <div class='info'>
          <span class='created-at'>Created At $task->created_at </span>
          <a href='' class='deleteBtn' id='$task->id'  class='remove' style=' font-size: 21px; position: absolute; margin: -2px 12px 14px -26px; ' > x </a>
          </div>
          </li>";
        endforeach;
    }else {
        echo ' There is no Task here ... ';
    }

}

if(isset($_POST['action']) && $_POST['action'] == 'insertFolders'  )
{
  $folderName = $_POST['folderName'];

  if ($folderName == 0) {
      echo("Warning : Folder name should not be empty ") ;
  }else{
    $Folders->insertQuery();
  }
}

if (isset($_POST['action']) && $_POST['action'] == 'insertTask') 
{
    $folderId = $_POST['folderId'];
    $TaskName = $_POST['TaskName'];
    
    if ($folderId == 0) {
      echo("Warning : Choose a Folder ") ;
    }elseif(empty($TaskName)){
      echo("Warning : Task should not be empty ") ;
    }else{
      $Tasks->insertQuery();
    }
    
}


if(isset($_POST['action']) && $_POST['action'] == 'deleteTask'  )
{
      $id = $_POST['deleteBtn'];
      $Tasks->deleteQuery($id);

}

if(isset($_POST['action']) && $_POST['action'] == 'deleteFolder'  )
{
      $id = $_POST['deleteBtn'];
       $Folders->deleteQuery($id);

}

if(isset($_POST['action']) && $_POST['action'] == 'updateDone'  )
{
      $id = $_POST['updateBtn'];
      $Tasks->updateQuery($id);

}


