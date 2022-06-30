<?php 
   $Designation  =  $this->session->Designation;
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Users</title>
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
            <li><i class="fa fa-bank blue_icon"></i>&nbsp;&nbsp;<a href="javascript:;">Users</a></li>
         </ul>
      </div>
      <!--===============================================================================================-->
      <form name="userview" action="<?= base_url() ?>Dashboard/index" id="userview" method="post">
            <input type="hidden" name="userhiddenid" id="userhiddenid">
            <input type="hidden" name="usernamehiddenid" id="usernamehiddenid">
      </form>
      <!--===============================================================================================-->
      <div class="portlet-body">
         <table class="table table-striped table-bordered table-hover hideIt" id="work-table">
            <thead>
               <tr style="background-color: #35363a;color: #fff;">
                  <th style="color:#fff;">Users  </th>
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
           // alert(Status);
           $('#work-table').dataTable().fnClearTable();
           $('#work-table').dataTable().fnDestroy();
           $('#work-table').DataTable({ 
               processing: true,
               serverSide: true,
               ajax: { 
                   url: "<?= base_url() ?>Users/showWork",
                   type: "POST"
               },
           });
         } 
           
      </script>
      <!--===============================================================================================-->
      <script>
         function viewUsers(id,name) { 
               $('#userhiddenid').val(id);
               $('#usernamehiddenid').val(name); 
               $('#userview').submit();
         }
      </script>
      <!--===============================================================================================-->
   </body>
</html>