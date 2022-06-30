<?php 
   $Designation  =  $this->session->Designation;

 
   $status['']                   = "-- Select Status --";
   $status['Approved']           = "Approved";
   $status['Rejected']           = "Rejected";
   $status['Pending']            = "Pending";

   $workdate = array(
       'name'          => 'workdate',
       'id'            => 'workdate',
       'class'         => 'form-control',
       'placeholder'   => 'Work Date',
       // 'type'          => 'date',
       'value'         => date('Y-m-d'),
   );
   $count = array(
       'name'          => 'count',
       'id'            => 'count',
       'class'         => 'form-control',
       'placeholder'   => 'Count',
       'type'          => 'number' 
   );
   $estimatedTime = array(
       'name'          => 'estimatedTime',
       'id'            => 'estimatedTime',
       'class'         => 'form-control',
       'placeholder'   => 'EstimatedTime',
       'type'          => 'hidden'    
   );
   $note = array(
       'name'          => 'note',
       'id'            => 'note',
       'class'         => 'form-control',
       'placeholder'   => 'Note'    
   );
   $additionalTime = array(
       'name'          => 'additionalTime',
       'id'            => 'additionalTime',
       'class'         => 'form-control',
       'placeholder'   => 'Additional Time'    
   );
   $workStatus = array(
       'name'          => 'workStatus',
       'id'            => 'workStatus',
       'class'         => 'form-control',
       'placeholder'   => 'Work Status',
       'type'          => 'hidden',
       'value'         => 0 
   );
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Work</title>
      <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
      <!--===============================================================================================-->
      <script type="text/javascript" src="<?= base_url(); ?>public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
      <!--===============================================================================================-->
      <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
      <!--===============================================================================================--> 
      <script type="text/javascript" src="<?= base_url(); ?>public/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
      <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/plugins/bootstrap-datepicker/css/datepicker.css"/>
      <!--===============================================================================================-->
      <script type="text/javascript" src="<?php echo base_url(); ?>public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
      <!--===============================================================================================-->

   </head>
   </head>
   <body>
      <!--===============================================================================================-->
      <div class="page-bar">
         <ul class="page-breadcrumb">
            <li><i class="fa fa-bank blue_icon"></i>&nbsp;&nbsp;<a href="javascript:;">Work</a></li>
         </ul>
      </div>
    <!--===============================================================================================-->
      <input type="hidden" name="hiddenId" id="hiddenId" value="">
      <div class="portlet">
         <div class="portlet-title">
            <div class="caption">
               <i class="fa fa-edit"></i>Work
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
                  <div class="col-md-3">
                     <div class="form-group">
                        <select id='teamName' class="form-control">
                           <option value="">-- Select Team --</option>
                           <?php
                              foreach($Team as $r){
                                echo "<option value='".$r['Id']."'>".$r['TeamName']."</option>";
                              }
                              ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                        <select id='taskName' class="form-control">
                           <option value="">-- Select Task --</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <div class="form-group">
                         <?php echo form_dropdown('status', $status,'','class="form-control" id="status"'); ?>
                     </div>
                  </div>
                  <div class="col-md-3">
                     <a class="btn btn-warning" id="Filter" onclick="showWorkDetails()">Show</a>
                     <button type="button" class="btn btn-success" onclick="populateWorkModal()">Add Work</button>
                     <?php if($Designation == "Head of Operation" || $Designation == "Team Leader" || $Designation == "Team Manager" ) { ?>
                     <a type="button" class="btn btn-danger" href="<?= base_url(); ?>ApproveWork/index">Approve</a> 
                     <?php } ?>
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
                  <h5 class="modal-title" id="exampleModalLabel">Add New Work</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="col-md-12">
                     <div class="form-group">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label >Work Date</label>
                        <div class="input-group input-md date date-picker" >
                           <?php echo form_input($workdate);?> 
                           <span class="input-group-btn">
                           <button class="btn btn-default" type="button">
                           <i class="fa fa-calendar light_red_icon"></i></button>
                           </span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-5">Team Name</label>
                        <select id='modelTeamName' class="form-control">
                           <option>-- Select Team --</option>
                           <?php
                              foreach($Team as $r){
                                echo "<option value='".$r['Id']."'>".$r['TeamName']."</option>";
                              }
                              ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-5">Task Name</label>
                        <select id='modelTaskName' class="form-control">
                           <option>-- Select Task --</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-5">Count</label>
                        <?php echo form_input($count)?>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-5">Additional Time</label>
                        <?php echo form_input($additionalTime)?>
                        <?php echo form_input($estimatedTime)?>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="control-label col-md-5">Note</label>
                        <?php echo form_input($note)?>
                        <?php echo form_input($workStatus)?>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary" onclick="saveWorkDetails()">Save</button>
               </div>
            </div>
         </div>
      </div>
      <!-- End Modal Add Product-->
      <!--===============================================================================================-->
      <div class="portlet-body">
         <table class="table table-striped table-bordered table-hover hideIt" id="work-table">
            <thead>
               <tr style="background-color: #35363a;color: #fff;">
                  <th style="color:#fff;">Date</th>
                  <th style="color:#fff;">Team</th>
                  <th style="color:#fff;">Task</th>
                  <th style="color:#fff;">Count</th>
                  <th style="color:#fff;">Status</th>
                  <th style="color:#fff;">Note</th>
                  <th style="color:#fff;"><i class="fa fa-cogs"></i></th>
               </tr>
            </thead>
         </table>
      </div>
      <script>
         $(document).ready(function() {
            showWorkDetails();
         });
         function showWorkDetails()
          {
           var TeamName      = $('#teamName').val();
           var TaskName      = $('#taskName').val();
           var Status        = $('#status').val();
           // alert(Status);
           $('#work-table').dataTable().fnClearTable();
           $('#work-table').dataTable().fnDestroy();
           $('#work-table').DataTable({ 
               processing: true,
               serverSide: true,
               ajax: {
                   data: {
                    'TeamName'      : TeamName,
                    'TaskName'      : TaskName,
                    'Status'        : Status,
                    },
                   url: "<?php echo base_url() ?>Work/showWork",
                   type: "POST"
               },
           });
         } 
           
      </script>
      <!--===============================================================================================-->
      <script>
         function populateWorkModal() {
         $('#addModal').modal({
         backdrop: 'static',
            keyboard: false
         });
         $('#addModal .modal-title').html('Add Task');
         $('#workdate').val(date('Y-m-d'));
         $('#modelTeamName').val('');
         $('#modelTaskName').val('');
         $('#count').val('');
         $('#note').val('');
         $('#additionalTime').val('');
         $('#workStatus').val(0);
         $('#hiddenId').val('');
         $('#submitBtn').val('Save');
         }
      </script>
      <!--===============================================================================================-->
      <script>
         function saveWorkDetails() {
         var workdate                       = $('#workdate').val();
         var teamname                       = $('#modelTeamName').val();
         var taskname                       = $('#modelTaskName').val();
         var count                          = $('#count').val();
         var estimatedTime                  = $('#estimatedTime').val();
         var currespondingTime              = count*estimatedTime;
         var note                           = $('#note').val();
         var additionalTime                 = $('#additionalTime').val();
         var workStatus                     = $('#workStatus').val();
         var hiddenId                       = $('#hiddenId').val();
         if(!Validate()) {
         return false;
         }
         else {
         // App.initblockUI();
         $.ajax({
           url:'<?php echo base_url();?>Work/saveWork',
           type: 'POST',
           dataType:'',
           data: {
               'WorkDate'               : workdate,
               'TeamName'               : teamname,
               'TaskName'               : taskname,
               'Count'                  : count,
               'CurrespondingTime'      : currespondingTime,
               'Note'                   : note,
               'AdditionalTime'         : additionalTime,
               'WorkStatus'             : workStatus,
               'hiddenId'               : hiddenId
               },
            success: function(data){ 
               $('#work-table').DataTable().ajax.reload();
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
         required = ["workdate","modelTeamName","modelTaskName","count"];
         
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
         function deleteWork(id) {
               if(confirm("Are you sure to delete!")){
                     deleteWorkDetails(id);
               }
         }
         function deleteWorkDetails(id) {
         $.ajax({
                     url:        '<?= base_url(); ?>Work/deleteWorkData',
                     type:       'POST',
                     dataType:   '',
                     //async:      true,
                     data: {'Workid' :id },
                     success: function(data, status){
                        toastr.success(data,"Success");
                        $('#work-table').DataTable().ajax.reload();
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
         function editWork(id) {
         
         
         // App.initblockUI();
         $.ajax({
         url: '<?= base_url(); ?>Work/showWorkInformation',
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
            $('#workdate').val(data.WorkDate);
            $('#modelTeamName').val(data.TeamName);
            $('#modelTaskName').val(data.TaskName);
            $('#count').val(data.Count);
            $('#estimatedTime').val((data.CurrespondingTime)/(data.Count));
            $('#note').val(data.Note);
            $('#additionalTime').val(data.AdditionalTime);
            $('#workStatus').val(data.Status);
            $('#hiddenId').val(id);
            $('#submitBtn').val('Save');
            $('#addModal').modal({
                  backdrop: 'static',
                     keyboard: false
               });
            $('#addModal .modal-title').html('Edit Work');                   
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
      <script type='text/javascript'>
         // Team change
         $('#teamName').change(function(){
           var team                       = $('#teamName').val();
           $.ajax({
             url:'<?= base_url(); ?>Work/getTeamTask',
             method: 'post',
             data: {team: team},
             dataType: 'json',
             success: function(response){
               console.log(response);
               // Remove options 
               $('#taskName').find('option').not(':first').remove();
               // Add options
               $.each(response,function(index,data){
                  $('#taskName').append('<option value="'+data['Id']+'">'+data['TaskName']+'</option>');
               });
             }
          });
         });
         // Model Team Change
         $('#modelTeamName').change(function(){
           var team                       = $('#modelTeamName').val();
           $.ajax({
             url:'<?= base_url(); ?>Work/getTeamTask',
             method: 'post',
             data: {team: team},
             dataType: 'json',
             success: function(response){
               // Remove options 
               $('#modelTaskName').find('option').not(':first').remove();
               // Add options
               $.each(response,function(index,data){
                  $('#modelTaskName').append('<option value="'+data['Id']+'">'+data['TaskName']+'</option>');
               });
             }
          });
         });
         // Modal Task Change
         $('#modelTaskName').change(function(){
           var task                       = $('#modelTaskName').val();
           $.ajax({
             url:'<?= base_url(); ?>Work/getestimatedTime',
             method: 'post',
             data: {task: task},
             dataType: 'json',
             success: function(response){
                  $('#estimatedTime').val(response.EstimatedTime);
             }
          });
         });
      </script>
      <!--===============================================================================================-->
      <script>
         // Data Picker Initialization
          $(".date-picker").datepicker({format: 'yyyy-mm-dd',endDate: new Date() });
      </script>
      <!--===============================================================================================-->
   </body>
</html>