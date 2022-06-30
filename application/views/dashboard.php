<?php 
   // Year Dropdown Function
   function yearDropdownMenu($start_year, $end_year = null, $id='year_select', $selected=null) {
      $end_year = is_null($end_year) ? date('Y') : $end_year;
      $selected = is_null($selected) ? date('Y') : $selected;
      $r = range($start_year, $end_year);
      $select = '<select class="form-control" name="'.$id.'" id="'.$id.'">';
      foreach( $r as $year )
      {
          $select .= "<option value=\"$year\"";
          $select .= ($year==$selected) ? ' selected="selected"' : '';
          $select .= ">$year</option>\n";
      }
       $select .= '</select>';
      return $select;
       }
   // Month Dropdown Function
   function formMonth(){
    $selected_month = date('m'); //current month
   
    echo '<select class="form-control" name="month_select" id="month_select">'."\n";
    for ($i_month = 1; $i_month <= 12; $i_month++) { 
        $selected = ($selected_month == $i_month ? ' selected' : '');
        echo '<option value="'.$i_month.'"'.$selected.'>'. date('F', mktime(0,0,0,$i_month)).'</option>'."\n";
    }
    echo '</select>'."\n";
   }
   
   $userhidden = array(
       'name'          => 'UserId',
       'id'            => 'UserId',
       'class'         => 'form-control',
       'type'          =>  'hidden',
       'value'         => $userId    
   );
            
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Dashboard</title>
      <!--===============================================================================================-->
      <!-- <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" /> -->
      <!--===============================================================================================-->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/assets/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css"/>
      <!--===============================================================================================-->     
      <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
      <!--===============================================================================================-->
      <script type="text/javascript" src="<?= base_url(); ?>public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> 
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
            <li><i class="fa fa-bank green_icon"></i>&nbsp;&nbsp;<a href="javascript:;">Dashboard</a></li>
         </ul>
         <div class="btn-group pull-right col-centered"><?= $username?></div>
      </div>
      <!--===============================================================================================-->
      <?= form_input($userhidden)?>
      <div class="portlet">
         <div class="portlet-title">
            <div class="caption">
               <i class="fa fa-edit"></i>Dashboard
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
                        <?= formMonth();?>
                     </div>
                  </div>
                  <div class="col-md-5">
                     <div class="form-group">
                        <?= yearDropdownMenu(2016);?>
                     </div>
                  </div>
                  <div class="col-md-2">
                     <a class="btn btn-warning" id="Filter" onclick="showDashboard()">Show</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!--===============================================================================================-->
      <div class="portlet-body">
         <h1></h1>
         <table id="dashboard-table" class="table table-striped table-bordered table-hover hideIt">
            <thead>
               <tr style="background-color: #35363a;color: #fff;">
                  <td>Date</td>
                  <td>Total Count</td>
                  <td>Curresponding Time</td>
                  <td>AMS Time</td>
                  <td>Difference</td>
                  <td>Work Status</td>
                  <td style="display:none;"></td>
                  <td style="display:none;"></td>
                  <td style="display:none;"></td>
                  <!-- <td><i class="fa fa-cogs"></i></td> -->
               </tr>
            </thead>
            <tbody>
            </tbody>
         </table>
      </div>
      <!--===============================================================================================-->
      <!-- Modal User Details-->
      <div class="modal " id="userviewmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="col-md-12">
                     <h1></h1>
                     <table id="dashboard-details-table" class="table table-bordered table-striped table-hover">
                        <thead>
                           <tr>
                              <td>Task Name</td>
                              <td>Count</td>
                              <td>Estimated Time</td>
                              <td>Curresponding Time</td>
                              <!-- <td><i class="fa fa-cogs"></i></td> -->
                           </tr>
                        </thead>
                        <tbody>
                        </tbody>
                     </table>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                  <!-- <button type="submit" class="btn btn-primary" onclick="saveTeamDetails()">Save</button> -->
               </div>
            </div>
         </div>
      </div>
      <!-- End Modal User Details-->
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
                     <div class="form-group" id="notepopup">
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
      <script type="text/javascript">
         
         $(document).ready(function() {
            showDashboard();
            });
         function showDashboard() {
            var UserId      = $('#UserId').val();
            var Year        = $('#year_select').val();
            var Month       = $('#month_select').val();
            // alert(Month);
            // alert(Month);
            // alert(UserId);
             $('#dashboard-table').dataTable({
           "bDestroy": true
       }).fnDestroy();
             $('#dashboard-table').DataTable({
               "pageLength" : 5,
                 "ajax": {
                  // console.log('gvjfg');
                     data: {
                    'month'      : Month,
                    'year'       : Year,
                    'userId'     : UserId
                    },
                     url : "<?= base_url() ?>Dashboard/showDashboard",
                     type : 'POST'
                 },
                 columnDefs: [{
                     "targets": [6],
                     "visible": false,
                     "searchable": false
                 },
                 {
                     "targets": [7],
                     "visible": false,
                     "searchable": false
                 },
                 {
                     "targets": [8],
                     "visible": false,
                     "searchable": false
                 }],       
                 rowCallback: function (row, data, index) {
                   if (data[6] == 'Yes') {
                       $(row).find('td').css('background-color', 'orange');
                   }
                    if (data[8] == 'Yes') {
                       $(row).find('td:eq(4)').css('color', 'red');
                       $(row).find('td:eq(2)').css('background-color', '#5CB3FF');
                   }
               },
             });
             var table = $('#dashboard-table').DataTable();
             $('#dashboard-table tbody').on('dblclick', 'tr', function (e) {
                   var data = table.row( this ).data();
                   RowClick(data[0],data[7]);
                //}
             });
          }
         
         function RowClick(date,id)
          {
            // alert('ou');
           $('#dashboard-details-table').dataTable().fnClearTable();
           $('#dashboard-details-table').dataTable().fnDestroy();
           $('#dashboard-details-table').DataTable({ 
               processing: true,
               serverSide: true,
               ajax: {
                   data: {
                    'userId'     : id,
                    'date'       :date
                    },
                   url: "<?= base_url() ?>Dashboard/showDashboardDetails",
                   type: "POST"
               },
           });
            $('#userviewmodel').modal({
                 backdrop: 'static',
                 keyboard: false
               });
         $('#userviewmodel .modal-title').html('WorkDate:'+date);
         } 
         
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
            $('#notepopup').html(Note);
         }
      </script>
      <!--===============================================================================================-->
   </body>
</html>