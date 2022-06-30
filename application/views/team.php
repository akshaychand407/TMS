<?php 
   $Designation  =  $this->session->Designation;

   $teamLeader['']           = "-- Select Team Leader --";
   if($TeamLeader)
   {
    foreach ($TeamLeader->result() as $r)
     {
         $teamLeader[$r->Id] = $r->TeamLeaderName ;
       }
   }
   $teamManager['']           = "-- Select Team Manager --";
   if($TeamManager)
   {
    foreach ($TeamManager->result() as $r)
     {
         $teamManager[$r->Id] = $r->TeamManagerName ;
       }
   }
   
   $TeamName = array(
       'name'          => 'teamname',
       'id'            => 'teamname',
       'class'         => 'form-control',
       'placeholder'   =>  'Team Name'    
   );
      
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Team</title>
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
            <li><i class="fa fa-bank blue_icon"></i>&nbsp;&nbsp;<a href="javascript:;">Team</a></li>
         </ul>
      </div>
      <!--===============================================================================================-->
      <input type="hidden" name="hiddenId" id="hiddenId" value="">
      <div class="portlet">
         <div class="portlet-title">
            <div class="caption">
               <i class="fa fa-edit"></i>Team
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
                  <div class="col-md-5">
                     <div class="form-group">
                        <?php echo form_dropdown('teamLeader', $teamLeader,'','class="form-control" id="teamLeader"'); ?>
                     </div>
                  </div>
                  <div class="col-md-5">
                     <div class="form-group">
                        <?php echo form_dropdown('teamManager', $teamManager,'','class="form-control" id="teamManager"'); ?>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <a class="btn btn-warning" id="Filter" onclick="showTeamDetails()">Show</a>
                     <!-- <a class="btn btn-success" id="addteam" onclick="AddTeam()">Add Team</a> -->
                     <?php if($Designation == "Head of Operation" || $Designation == "Team Leader" || $Designation == "Team Manager" ) { ?>
                     <button type="button" class="btn btn-success mb-2" onclick="populateTeamModal()">Add</button>
                  <?php } ?>
                     <!-- <a class="btn btn-success" id="InvoiceToolExcel" onclick="getExcelReport()">Excel</a> -->
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--===============================================================================================-->
      <!-- Modal Add -->
      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add New Team</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="form-group">
                     <label>Team Name</label>
                     <?php echo form_input($TeamName)?>
                  </div>
                  <div class="form-group">
                     <label>Team Leader</label>
                     <?php echo form_dropdown('teamLeadername', $teamLeader,'','class="form-control" id="teamLeaderid"'); ?>
                  </div>
                  <div class="form-group">
                     <label>Team Leader</label>
                     <?php echo form_dropdown('teamManagername', $teamManager,'','class="form-control" id="teamManagerid"'); ?>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="submit" class="btn btn-primary" onclick="saveTeamDetails()">Save</button>
               </div>
            </div>
         </div>
      </div>
      <!-- End Modal Add -->
      <!--===============================================================================================-->
      <div class="portlet-body">
         <table class="table table-striped table-bordered " id="team-table" >
            <thead>
               <tr style="background-color: #35363a;color: #fff;">            
                  <th style="color:#fff;">Team Name</th>
                  <th style="color:#fff;">Team Leader</th>
                  <th style="color:#fff;">Team Manager</th>
                  <th style="color:#fff;">Actions <i class="fa fa-cogs"></i></th>
               </tr>
            </thead>
         </table>
      </div>
      <!--===============================================================================================-->
      <script>
         $(document).ready(function() {
            showTeamDetails();
         });
         function showTeamDetails()
          {
           var TeamLeader      = $('#teamLeader').val();
           var TeamManager      = $('#teamManager').val();
           $('#team-table').dataTable().fnClearTable();
           $('#team-table').dataTable().fnDestroy();
           $('#team-table').DataTable({ 
               processing: true,
               serverSide: true,
               ajax: {
                   data: {
                    'TeamLeader'      : TeamLeader,
                    'TeamManager'     : TeamManager
                    },
                   url: "<?php echo base_url() ?>Team/showTeam",
                   type: "POST"
               },               
           });
         } 
           
      </script>
      <!--===============================================================================================-->
      <script>
         function populateTeamModal() {
         $('#addModal').modal({
         backdrop: 'static',
            keyboard: false
         });
         $('#addModal .modal-title').html('Add Team');
         $('#teamname').val('');
         $('#teamLeaderid').val(''); 
         $('#teamManagerid').val('');
         $('#hiddenId').val('') ;
         $('#submitBtn').val('Save');
         }
      </script>
      <!--=============================================Save==================================================-->
      <script>
         function saveTeamDetails() {
         var teamname              = $('#teamname').val();
         var teamLeader            = $('#teamLeaderid').val();
         var teamManager           = $('#teamManagerid').val();
         var hiddenId              = $('#hiddenId').val();
         if(!Validate()) {
         return false;
         }
         else {
         App.initblockUI();
         $.ajax({
           url:'<?php echo base_url();?>Team/saveTeam',
           type: 'POST',
           dataType:'json',
           data: {
               'TeamName'        : teamname,
               'TeamLeader'      : teamLeader,
               'TeamManager'     : teamManager,
               'hiddenId'        : hiddenId
               },
            success: function(data){
                  $('#addModal').modal('hide'); 
                  toastr.success(data,"Success");
                  $('#team-table').DataTable().ajax.reload();
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
         required = ["teamname","teamLeaderidid","teamManagerid"];
         
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
         function deleteTeam(id) {
               if(confirm("Are you sure to delete!")){
                     deleteTeamDetails(id);
               }
         }
         function deleteTeamDetails(id) {
         $.ajax({
                     url:        '<?= base_url(); ?>Team/deleteTeamData',
                     type:       'POST',
                     dataType:   '',
                     //async:      true,
                     data: {'Teamid' :id },
                     success: function(data, status){
                        toastr.success(data,"Success");
                        $('#team-table').DataTable().ajax.reload();
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
         function editTeam(id) {
         
         
         // App.initblockUI();
         $.ajax({
         url: '<?= base_url(); ?>Team/showTeamInformation',
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
            $('#teamname').val(data.TeamName);
            $('#teamLeaderid').val(data.TeamLeader);
            $('#teamManagerid').val(data.TeamManager);
            $('#hiddenId').val(id);
            $('#submitBtn').val('Save');
            $('#addModal').modal({
                  backdrop: 'static',
                     keyboard: false
               });
            $('#addModal .modal-title').html('Edit Team');                   
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