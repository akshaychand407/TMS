<?php 
$Designation  =  $this->session->Designation;

$teamName['']           = "-- Select Team --";
   if($Team)
   {
    foreach ($Team->result() as $r)
     {
         $teamName[$r->Id] = $r->TeamName ;
       }
   }

$TaskName = array(
    'name'          => 'taskname',
    'id'            => 'taskname',
    'class'         => 'form-control',
    'placeholder'   =>  'Task Name'    
);
$estimatedTime = array(
    'name'          => 'estimatedtime',
    'id'            => 'estimatedtime',
    'class'         => 'form-control',
    'placeholder'   => 'EstimatedTime'    
);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Task</title>
      <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
      <!--===============================================================================================-->     
      <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
      <!--===============================================================================================--> 
      <script type="text/javascript" src="<?= base_url(); ?>public/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
      <!--===============================================================================================-->
</head>
<body>
    <!--===============================================================================================-->
      <div class="page-bar">
         <ul class="page-breadcrumb">
            <li><i class="fa fa-bank blue_icon"></i>&nbsp;&nbsp;<a href="javascript:;">Task</a></li>
         </ul>
      </div>
    <!--===============================================================================================-->
   <input type="hidden" name="hiddenId" id="hiddenId" value="">
   <div class="portlet">
   <div class="portlet-title">
      <div class="caption">
         <i class="fa fa-edit"></i>Task
      </div>
      <div class="tools">
         <a href="javascript:;" class="collapse">
         </a>
         <a href="#portlet-config" data-toggle="modal" class="config">
         </a>
         <a href="javascript:;" class="reload">
         </a>               
      </div>
   </div>
   <div class="portlet-body">
      <div class="table-toolbar">
         <div class="row"> 
            
            <div class="col-md-10">
               <div class="form-group">
                  <?= form_dropdown('teamName', $teamName,'','class="form-control" id="teamName"'); ?>
               </div>
            </div>            
            <div class="col-md-2">
               <a class="btn btn-warning" id="Filter" onclick="showTaskDetails()">Show</a>
               <?php if($Designation == "Head of Operation" || $Designation == "Team Leader" || $Designation == "Team Manager" ) { ?>
               <button type="button" class="btn btn-success mb-2" onclick="populateTaskModal()">Add Task</button>
               <?php } ?> 
               <!-- <a class="btn btn-success" id="InvoiceToolExcel" onclick="getExcelReport()">Excel</a> -->
            </div> 
         </div>

         
      </div>
   </div>   
</div>
	<!--===============================================================================================-->
      <!-- Modal Add Task-->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
             
                <div class="form-group">
                    <label>Task Name</label>
                    <?= form_input($TaskName)?>
                </div>
                <div class="form-group">
                    <label>Team Name</label>
                    <?= form_dropdown('Team Name', $teamName,'','class="form-control" id="teamnameid"'); ?>
                </div>
                <div class="form-group">
                    <label>Estimated Time</label>
                    <?= form_input($estimatedTime)?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" onclick="saveTaskDetails()">Save</button>
            </div>
            </div>
        </div>
        </div>
    <!-- End Modal Add Task-->
   <!--===============================================================================================-->
      <div class="portlet-body">
      <table class="table table-striped table-bordered" id="task-table">
         <thead>
            <tr style="background-color: #35363a;color: #fff;">
               <!-- <th style="color:#fff;">Id</th> -->
               <th style="color:#fff;" >Task Name</th>
               <th style="color:#fff;">Team</th>
               <th style="color:#fff;">Estimated Hours</th>
               <th style="color:#fff;"><i class="fa fa-cogs"></i></th>
            </tr>
         </thead>
      </table>
   </div>
   <!--===============================================================================================-->
      <script>
         $(document).ready(function() {
            showTaskDetails();
         });
         function showTaskDetails()
          {
           var TeamName      = $('#teamName').val();
           $('#task-table').dataTable().fnClearTable();
           $('#task-table').dataTable().fnDestroy();
           $('#task-table').DataTable({ 
               processing: true,
               serverSide: true,
               ajax: {
                   data: {
                    'TeamName'      : TeamName
                    },
                   url: "<?= base_url() ?>Task/showTask",
                   type: "POST"
               },
           });
         } 
      </script>
      <!--===============================================================================================-->
      <script>
         function populateTaskModal() {
         $('#addModal').modal({
         backdrop: 'static',
            keyboard: false
         });
         $('#addModal .modal-title').html('Add Task');
         $('#taskname').val('');
         $('#teamnameid').val('');
         $('#estimatedtime').val('');
         $('#hiddenId').val('');
         $('#submitBtn').val('Save');
         }
      </script>
      <!--===============================================================================================-->
       <script>
         function saveTaskDetails() {
      var taskname              = $('#taskname').val();
      var teamname              = $('#teamnameid').val();
      var estimatedtime         = $('#estimatedtime').val();
      var hiddenId              = $('#hiddenId').val();
      if(!Validate()) {
         return false;
       }
       else {
       App.initblockUI();
       $.ajax({
           url:'<?= base_url();?>Task/saveTask',
           type: 'POST',
           dataType:'',
           data: {
               'TaskName'        : taskname,
               'TeamName'        : teamname,
               'EstimatedTime'   : estimatedtime,
               'hiddenId'        : hiddenId
               },
            success: function(data){
               $('#task-table').DataTable().ajax.reload();
               $('#addModal').modal('hide'); 
               toastr.success(data,"Success");
               App.initunblockUI(); 
           },
           error : function(xhr, textStatus, errorThrown) {
             if (xhr.status === 0) {
               alert('Not connected. Verify Network.');
             } else if (xhr.status == 404) {
               alert('Requested page not found. [404]');
             } else if (xhr.status == 500) {
               alert('Server Error [500].'); 
             } else if (errorThrown === 'parsererror') {
               alert('Requested JSON parse failed.');
             } else if (errorThrown === 'timeout') {
               alert('Time out error.');
             } else if (errorThrown === 'abort') {
               alert('Ajax request aborted.');
             } else {
               alert('Remote sever unavailable. Please try later');
             }
           }
         });
   }
}
function Validate(){

       var errornotice = $("#error");
       var emptyerror  = "Please fill out this field.";
       var numerror    = "Please enter a valid number.";

$('input').removeClass('error');
$('select').removeClass('error');
//Validate required fields
required = ["taskname","teamnameid","estimatedtime"];

for (i=0;i<required.length;i++) {
var input = $('#'+required[i]);
if ((input.val() == "") || (input.val() == emptyerror)) {
input.addClass("error");
/*input.val(emptyerror);*/
input.attr("placeholder", emptyerror);
errornotice.slideDown(750);
} else {
input.removeClass("error");

}
}
if ($(":input").hasClass("error")) {
return false;
} else {
errornotice.hide();
return true;
}
}
      </script>
      <!--===============================================================================================-->
      <script>
         function deleteTask(id) {
               if(confirm("Are you sure to delete!")){
                     deleteTaskDetails(id);
               }
         }
         function deleteTaskDetails(id) {
         $.ajax({
                     url:        '<?= base_url(); ?>Task/deleteTaskData',
                     type:       'POST',
                     dataType:   '',
                     //async:      true,
                     data: {'Taskid' :id },
                     success: function(data, status){
                           toastr.success(data,"Success");
                           $('#task-table').DataTable().ajax.reload();
                     },
                     error : function(xhr, textStatus, errorThrown) {
                           if (xhr.status === 0) {
                                 alert('Not connected. Verify Network.');
                           } else if (xhr.status == 404) {
                                 alert('Requested page not found. [404]');
                           } else if (xhr.status == 500) {
                                 alert('Server Error [500].');
                           } else if (errorThrown === 'parsererror') {
                                 alert('Requested JSON parse failed.');
                           } else if (errorThrown === 'timeout') {
                                 alert('Time out error.');
                           } else if (errorThrown === 'abort') {
                                 alert('Ajax request aborted.');
                           } else {
                                 alert('Remote sever unavailable. Please try later');
                           }
                     }
         });
         }
      </script>
      <!--===============================================================================================-->
      <script>
         function editTask(id) { 
         // App.initblockUI();
         $.ajax({
         url: '<?= base_url(); ?>Task/showTaskInformation',
         type: 'POST',
         dataType:'json',
         data: {
         'hiddenId'     : id,
         },
         success: function(data, status){ 
         
            if(data.status == '0'){
               toastr.error(data.message,"Error");
            }
            else { 
             // alert(id);
            $('#taskname').val(data.TaskName);
            $('#teamnameid').val(data.TeamName);
            $('#estimatedtime').val(data.EstimatedTime);
            $('#hiddenId').val(id);
            $('#submitBtn').val('Save');
            $('#addModal').modal({
                  backdrop: 'static',
                     keyboard: false
               });
            $('#addModal .modal-title').html('Edit Task');                   
               // App.initunblockUI(); 
           }
         },
         error : function(xhr, textStatus, errorThrown) {
          if (xhr.status === 0) {
            alert('Not connected. Verify Network.');
          } else if (xhr.status == 404) {
            alert('Requested page not found. [404]');
          } else if (xhr.status == 500) {
            alert('Server Error [500].'); 
          } else if (errorThrown === 'parsererror') {
            alert('Requested JSON parse failed.');
          } else if (errorThrown === 'timeout') {
            alert('Time out error.');
          } else if (errorThrown === 'abort') {
            alert('Ajax request aborted.');
          } else {
            alert('Remote sever unavailable. Please try later');
          }
         }
         });
         }
      </script>
      <!--===============================================================================================-->
</body>
</html>