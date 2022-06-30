<?php 
   $Designation  =  $this->session->Designation;
   
   $user['']                   = "-- Select User --";
    if($User)
   {
    foreach ($User->result() as $r)
     {
         $user[$r->Id] = $r->User ;
       }
   }
   
   
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Approve Work</title>
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
   <body>
      <!--===============================================================================================-->
      <div class="page-bar">
         <ul class="page-breadcrumb">
            <li><i class="fa fa-bank blue_icon"></i>&nbsp;&nbsp;<a href="<?= base_url(); ?>Work/index">Work</a>
            <i class="fa fa-angle-right"></i><a href="<?= base_url(); ?>ApproveWork/index">Approve Work</a>
            </li>
         </ul>
      </div>
      <!--===============================================================================================-->
      <input type="hidden" name="hiddenId" id="hiddenId" value="">
      <div class="portlet">
         <div class="portlet-title">
            <div class="caption">
               <i class="fa fa-edit"></i>Approve Work
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
                        <?= form_dropdown('user', $user,'','class="form-control" id="user"'); ?>
                     </div>
                  </div>
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
                     <a class="btn btn-warning" id="Filter" onclick="showWorkDetails()">Show</a>
                     <?php if($Designation == "Head of Operation" || $Designation == "Team Leader" || $Designation == "Team Manager" ) { ?>
                     <button type="button" class="btn btn-success" onclick="aproveAllWork()">Approve</button> 
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--===============================================================================================-->
      <!-- Modal Reject Note-->
      <div class="modal fade" id="rejectNoteModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
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
                  <div class="col-md-12">
                     <div class="form-group">
                        <label class="control-label col-md-4">Reject Note</label>
                        <textarea name="rejectNote" id="rejectNote" class="col-md-12"></textarea>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-primary" onclick="reject()">Ok</button>
               </div>
            </div>
         </div>
      </div>
      <!-- End Modal Reject Note-->
      <!--===============================================================================================-->
      <!-- Modal Display Note-->
      <div class="modal fade" id="displayNoteModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="col-md-12">
                     <div class="form-group">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group" id="note">
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
               </div>
            </div>
         </div>
      </div>
      <!-- End Modal Display Note-->
      <!--===============================================================================================-->
      <div class="portlet-body">
         <table class="table table-striped table-bordered table-hover hideIt" id="work-table">
            <thead>
               <tr style="background-color: #383838;color: #fff;">
                  <th><input type="checkbox" name="" class="checkboxSelectALL" id="checkboxSelectALL"></th>
                  <th style="color:#fff;">Work Date</th>
                  <th style="color:#fff;">User</th>
                  <th style="color:#fff;">Team</th>
                  <th style="color:#fff;">Task(Estimated Hours)</th>
                  <th style="color:#fff;">Count</th>
                  <th style="color:#fff;">Actions <i class="fa fa-cogs"></i></th>
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
           var User          = $('#user').val();
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
                    'User'          : User,
                    },
                   url: "<?= base_url() ?>ApproveWork/showWork",
                   type: "POST"
               },
               columnDefs: [{
                   "targets": [0],
                   "visible": true,
                   "searchable": true,
                  "orderable": false
               }],
           });
         } 
           
      </script>
      <!--===============================================================================================-->
      <!-- Approve Work -->
      <script>
         function aproveAllWork()
         {
         var id                 =       [];
         $('.checkbox:checked').each(function() {
         id.push($(this).val());
         });
           aproveWork(id);
         }
         function aproveWork(id) {
         $.ajax({
                     url:        '<?= base_url(); ?>ApproveWork/approveWork',
                     type:       'POST',
                     dataType:   '',
                     data: {'Workid' :id },
                     success: function(data, status){
                           $('#work-table').DataTable().ajax.reload();
                           toastr.success(data,"Success");
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
      <!-- Reject work -->
      <script>
         function rejectWork(id){
            $('#rejectNoteModel').modal({
                  backdrop: 'static',
                     keyboard: false
               });
            $('#rejectNoteModel .modal-title').html('Add your reject note');
            $('#hiddenId').val(id);
         }
         function reject() {
            var rejectnote       = $('#rejectNote').val();
            var hiddenId         = $('#hiddenId').val();
         $.ajax({
                     url:        '<?= base_url(); ?>ApproveWork/rejectWork',
                     type:       'POST',
                     dataType:   '',
                     data: {
                             'Workid'        :hiddenId,
                             'rejectNote'    :rejectnote
                      },
                     success: function(data, status){
                           $('#work-table').DataTable().ajax.reload();
                           $('#rejectNoteModel').modal('hide');
                           toastr.success(data,"Success");
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
      <!-- Select all checkbox -->
      <script>
         $(document).on('click', '#checkboxSelectALL', function() {
         if($(this).is(':checked')){
         $(".checkbox").prop('checked', true);
         }else{
         $(".checkbox").prop('checked', false);
         }  
         });
       </script>
      <!--===============================================================================================-->
      <!-- Display notes as pop up message -->
      <script>
         function displayNotes(Note) {
          $('#displayNoteModel').modal({
                  backdrop: 'static',
                     keyboard: false
               });
            $('#displayNoteModel .modal-title').html('Note');
            $('#note').html(Note);
         }
      </script>
      <!--===============================================================================================-->
      <!-- Team dropdown change -->
      <script type='text/javascript'>
         $('#teamName').change(function(){
           var team                       = $('#teamName').val();
           $.ajax({
             url:'<?= base_url(); ?>ApproveWork/getTeamTask',
             method: 'post',
             data: {team: team},
             dataType: 'json',
             success: function(response){
               // Remove options 
               $('#taskName').find('option').not(':first').remove();
               // Add options
               $.each(response,function(index,data){
                  $('#taskName').append('<option value="'+data['Id']+'">'+data['TaskName']+'</option>');
               });
             }
          });
         });
      </script>
      <!--===============================================================================================-->
   </body>
</html>