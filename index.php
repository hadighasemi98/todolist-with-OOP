<?php
include __DIR__ . "/autoLoad.php";


use App\Classes\Folders;
use App\Classes\Task;

$Tasks = new Task();
$Folders = new Folders();

// if(isset($_POST['searchInput'])){$Tasks->selectQuery();}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title> Task manager UI</title>
  <link rel="stylesheet" href="css/style.css?v="<?= rand(95,9999999) ?> >
</head>

<body >
  <!-- partial:index.partial.html -->
  <div class="page">
    <div class="pageHeader">
      <div class="title">Dashboard</div>
      <div class="userPanel">
        <a href="<?= __DIR__ ?>('?logout=1')?>"><i class="fa fa-sign-out"></i></a>

        <span class="username">Unknown </span>
        <img src="" width="40" height="40" /></div>
    </div>
    <div class="main">
      <div class="nav">
        <div class="searchbox">
        <!-- search -->
        <!-- <form method="POST"> -->
          <div><i class="fa fa-search"></i>
            <input id="input-search" type="search" name="searchInput" placeholder="Search" />
            <!-- <button type="submit" name="sub" >sub</button> -->
            <div class="searchResult" id="result-input"> </div>
            <!-- </form> -->

          </div>
        </div>
        <div class="menu">
          <div class="title">Folders</div>
          <ul class="folder-list">
            <li class="<?= isset($_GET['folder_id']) ? '' : 'active' ?>"><a href="<?php __DIR__ ?>index.php"><i class="fa fa-folder-open"></i>All</a></li>
            <div id="tableData">

            </div>
          </ul>
          <div>
            <form id="formData" method="POST">

            <input type="text" name='folderName' id="newFolderInput" placeholder="Add New Folder" />
            <button type='submit' class="clickable" id="submit">+</button>
            </form>
            <br>
            <div id='insertFolderError' style="margin-right: 16%;color: red;text-align: center;font-size: 1rem;" > </div>
          </div>
        </div>
      </div>
      <div class="view">
        <div class="viewHeader">
          <!-- newTaskInput -->
          <form id="insertTask" method="POST">
          <div class="title">
            <input type="text" style="width: 180%; line-height: 30px; margin:5px;" id="newTaskInput" placeholder="Press enter to add new Task ">
            <!-- <button type='submit' class="clickable" name="submitTask">++++</button> -->

          </div>
          </form>
          <div class="functions">
          <a href="<?php __DIR__ ?>index.php?done=1" id='doneTask' class='done'><div name ="descButton" class="button active">DONE</div></a>
          <a href="<?php __DIR__ ?>index.php?pending=1" id='pendingTask' class='pending'><div class="button active">Pending...</div></a>

          </div>
        </div>
        <div class="content">
          <div class="list">
            <div class="title">Today</div>

            <!-- Show insert Task error -->
            <div id='insertTaskError' style="color: red;font-size: 1rem;text-align: center;background-color: #eee;" > </div>
            
            <ul class="Task-list">
            <div id="showTasks">

            </div>
              <!-- getTasks -->
              <!-- <#php if(!$Tasks->selectQuery() < 1 ){ #>
                <#php foreach ($Tasks->selectQuery() as $task) : #>
                  <li class="<#= $task->status==1 # 'checked' : ''; #>">
                    <i data-taskId="<#= $task->id #>" class="clickable isDone <#= $task->status ? 'fa fa-check-square-o' : 'fa fa-square-o'; ?>"></i>
                    <span><#= $task->name ?></span>
                    <div class="info">
                      <span class="created-at">Created At <#= $task->created_at ?></span>
                      <a href="?delete_task=<#= $task->id ?> " class="remove" onclick="return confirm('Are You sure to Delete This Item ?');"> x </a>
                    </div>
                  </li>
                <#php endforeach; ?>
                <#php }else{echo " There is no Task here ... ";} ?> -->
            </ul>
          </div>
          <div class="list">
            <div class="title">Tomorrow(Processing... )</div>
            <br>
            <ul>
            <a href="<?php __DIR__ ?>index.php?<?= isset($_GET['folder_id']) ? 'folder_id='.$_GET['folder_id'].'&page=1&page_size=7' : 'page=1&page_size=7'?>" style="margin-left: 40%;" class="next"> 1 <a>
            <a href="<?php __DIR__ ?>index.php?<?= isset($_GET['folder_id']) ? 'folder_id='.$_GET['folder_id'].'&page=2&page_size=7' : 'page=2&page_size=7'?>"  class="next "> 2 </a>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- partial -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <!-- <script src="assets/js/script.js"></script> -->

  <script type="text/javascript">

  $(document).ready(function() {

   
   showFolders();
   // Get Folders With Ajax
   function showFolders(){
     $.ajax({
       url : "process/Ajax-insertTask.php",
       type: "POST",
       data : {action:"viewFolders"},
       success:function(response){
         // alert(response);
           $("#tableData").html(response);
         }
       });
     }

    showTasks();
    // Get Tasks With Ajax
    function showTasks(){
     $.ajax({
       url : "process/Ajax-insertTask.php",
       type: "POST",
       data : {
         action:"viewTasks",
         folderId :<?= $_GET['folder_id']    ?? 0 ?>, 
         page_size:<?= $_GET['page_size']    ?? 0 ?>, 
         page     :<?= $_GET['page']         ?? 0 ?>, 
         done     :<?= $_GET['done']         ?? 0 ?>, 
         pending  :<?= $_GET['pending']      ?? 0 ?>,
        //  searchInput:searchInput
        },
       success:function(response){
        //  alert(response);
           $("#showTasks").html(response);          
         }
       });
      }

  //insert Folder  
  $("#submit").click(function(e){
    e.preventDefault();
    var folderName = <?= $_POST['folderName'] ?? 0 ?>;
    $.ajax({
      url : "process/Ajax-insertTask.php",
      type : "POST",
      data : $("#formData").serialize()+"&action=insertFolders",
      success:function(response){
        if(folderName == 0){ // Print warning
          $("div#insertFolderError").text(response);
        }
        $("#formData")[0].reset(); 
        showFolders();
      }
    });
    });

    //insert Task
      $('#newTaskInput').on('keypress', function(e) {
        if (e.which == 13) { //Enter key on keyboard == 13
        e.preventDefault();
        var folder   = <?= $_GET['folder_id'] ?? 0 ?>;
        var TaskName = <?= $_POST['TaskName'] ?? 0 ?>;
      $.ajax({
        url : "process/Ajax-insertTask.php",
        type : "POST",
        data : {
          action:"insertTask",
          folderId: <?= $_GET['folder_id'] ?? 0 ?>, TaskName: $('#newTaskInput').val()
        },
        success:function(response){
          // Show error message 
          if(folder == 0 || TaskName == ''){ // Print warning
            $("div#insertTaskError").text(response); 
          }
          $("#insertTask")[0].reset();
          showTasks();
        }
      
      });
    }
    });

    //Delete Task
    $("body").on("click",".deleteBtn", function(e){
      e.preventDefault();
      var tr = $(this).closest('li');
      var deleteBtn = $(this).attr('id');
      if (confirm('Are you sure want to delete this Record')) {
        $.ajax({
          url : "process/Ajax-insertTask.php",
          type : "POST",
          data : {
            deleteBtn:deleteBtn,
            action:"deleteTask"
          },
          success:function(response){
            // alert(response);
            tr.css('background-color','#ff6565');
            showTasks();
          }
        });
      }
    });

    //Delete Folder
    $("body").on("click",".remove", function(e){
      e.preventDefault();
      var tr = $(this).closest('li');
      var deleteBtn = $(this).attr('id');
      if (confirm('Are you sure want to delete this Record')) {
        $.ajax({
          url : "process/Ajax-insertTask.php",
          type : "POST",
          data : {
            deleteBtn:deleteBtn,
            action:"deleteFolder"
          },
          success:function(response){
            // alert(response);
            tr.css('background-color','#ff6565');
            showFolders();
          }
        });
      }
    });

    // Done Switch 
    $("body").on("click",".clickable", function(e){
      e.preventDefault();
      var updateBtn = $(this).attr('data-taskId');
        $.ajax({
          url : "process/Ajax-insertTask.php",
          type : "POST",
          data : {
            updateBtn:updateBtn,
            action:"updateDone"
          },
          success:function(response){
            // alert(response);
            showTasks();
          }
        });
    });

    // Search 
    // $("body").on("click",".clickable", function(e){
    //   e.preventDefault();
    //   var updateBtn = $(this).attr('data-taskId');
    //     $.ajax({
    //       url : "process/Ajax-insertTask.php",
    //       type : "POST",
    //       data : {
    //         updateBtn:updateBtn,
    //         action:"updateDone"
    //       },
    //       success:function(response){
    //         // alert(response);
    //         showTasks();
    //       }
    //     });
    // });


      $('#newTaskInput').focus();
    });
  </script>

</body>

</html>

 