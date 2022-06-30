 <?php
class DashboardModel extends CI_Model {
function __construct(){
        $this->load->model('DatabaseModel');
parent::__construct(); 
}
public function groupAllDate($UserId,$Month,$Year){ 
        $Id= $this->session->Id;
        // print_r($Month);die('uhur');
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $this->db->select('WorkDate,count(Id) as num');
        $this->db->group_by('WorkDate');
        $this->db->order_by('WorkDate','ASC');
        $this->db->where('RecordStatus',1);
        if( $UserId != ''){
            $this->db->where('CreatedBy',$UserId);
        }
        else{
        $this->db->where('CreatedBy',$Id);
        }
        if($Month =='' && $Year =='')
        {
        }
        else if($Month !='' && $Year != '')
        {
        $this->db->where('Year(WorkDate)',$Year);
        $this->db->where('Month(WorkDate)',$Month);
        }
        $query = $this->db->get('work_tb');
        // echo $this->db->last_query();die('jja');
        $data = array();
        foreach ($query->result() as $r ) {
            for ($i=0; $i < $r->num; $i++) { 
               $this->db->where(array('RecordStatus' => 1, 'WorkDate' => $r->WorkDate));
               $result= $this->db->get('work_tb')->result();
               $row= array();
               // $result->result();
               $Count=0;
               $CurrespondingTime=0;
               $Approved=0;
               $Rejected=0;
               $Pending=0;
               foreach($result as $r) {
                  $id                                 = $r->CreatedBy;
                  $Count                              = $Count+$r->Count;
                  $CurrespondingTime                  = $CurrespondingTime+$r->CurrespondingTime;
                  $originalDate                       = $r->WorkDate;
                  $Date                               = date("d-m-Y", strtotime($originalDate));
                  $AmsTime                            = $r->AmsTime;
                  $Status                             = $r->Status;
                  $AdditionalTime                     = $r->AdditionalTime;
                  if ($Status==2) {
                        $Reject++;
                        $Reject++;
                        $Reject++;    
                        $Reject++;
                  }elseif($Status==1){
                        $Approved++;
                  }else{
                        $Pending++;
                  }
                }
               }
               $row[]                                  = $Date;
               $row[]                                  = $Count;
               $CurrespondingTimeinHours               = sprintf('%02d',intdiv($CurrespondingTime, 60)) .':'. ( sprintf('%02d',$CurrespondingTime % 60));
               $row[]                                  = $CurrespondingTimeinHours;
               $row[]                                  = $AmsTime;
               $timesplit                              = explode(':',$AmsTime);
               $AmsTimeinMinutes                       = ($timesplit[0]*60)+($timesplit[1])+($timesplit[2]>30?1:0);
               $DifferenceinMinutes                    = ($AmsTimeinMinutes-$CurrespondingTime);
               $Difference                             = sprintf('%02d',intdiv($DifferenceinMinutes, 60)) .':'. ( sprintf('%02d',$DifferenceinMinutes % 60));
               $row[]                                  = $Difference;
               if($Rejected>$Approved && $Rejected>$Pending) {
                $row[]                                 = 'Rejected';
               }elseif ($Pending>$Approved && $Pending>$Rejected) {
                $row[]                                 = 'Pending';       
               }else{
                $row[]                                 = 'Approved';
               }
               if ($AdditionalTime != 0) {
                   $row[]                              = 'Yes';
               }else{
                $row[]                                 = 'No';
               }
               $row[]                                  = $id;
               if(($AmsTimeinMinutes-$CurrespondingTime)>60){
                 $row[]                                = 'Yes';
               }
               else{
                  $row[]                               = 'No';
               }

               $data[]                                 = $row;
        }
        $output           = array(
        "draw"            => $draw,
        "recordsTotal"    => count($data),
        "recordsFiltered" => count($data),
        "data"            => $data
        );
        echo json_encode($output);
        exit();

    }

public function getDashboarddetails($userId,$date){
        $draw   = intval($this->input->get("draw"));
        $start  = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        if($this->input->post('order')){  
             $tableCols    =   array("task_tb.TaskName","work_tb.Count" ,"task_tb.EstimatedTime","work_tb.CurrespondingTime");
             $sortCol    = $this->input->post('order')[0]['column'];
             $sortOrder    =   $this->input->post('order')[0]['dir'];
             $orderBy    = '';
       
             if($tableCols[$sortCol]){
               $orderBy =  $tableCols[$sortCol]." ".$sortOrder;  
             } 
           }
         if (!empty($orderBy) ) {
           $this->db->order_by($orderBy);
         }
         extract($this->input->post('search'), EXTR_PREFIX_SAME, "wddx"); 
         $search        =    $value ? $value : null;
         if($search) 
         {
         $search   = array('task_tb.TaskName' => $search,'work_tb.CurrespondingTime' => $search,'task_tb.EstimatedTime' => $search,'work_tb.Count' => $search);
            }
         if (!empty($search)) 
         {
         $this->db->group_start();
         $this->db->or_like($search);
         $this->db->group_end();
         }      
        $this->db->select('task_tb.TaskName,task_tb.EstimatedTime,work_tb.Count,work_tb.CurrespondingTime,work_tb.Note,work_tb.AdditionalTime');
        $this->db->where('work_tb.RecordStatus',1);
        $this->db->where('work_tb.CreatedBy',$userId);
        $this->db->where('work_tb.WorkDate',$date);
        $this->db->from('work_tb');
        $this->db->join('task_tb','task_tb.Id = work_tb.Task');
        $query = $this->db->get( ); 
        $data = array();

          if($query->num_rows())
          {
           foreach($query->result() as $r) 
           {
               $EstimatedTime                           = $r->EstimatedTime;
               $EstimatedTimeinHours                    = sprintf('%02d',intdiv($EstimatedTime, 60)) .':'. ( sprintf('%02d',$EstimatedTime % 60));
               $CurrespondingTime                       = $r->CurrespondingTime;
               $CurrespondingTimeinHours                = sprintf('%02d',intdiv($CurrespondingTime, 60)) .':'. ( sprintf('%02d',$CurrespondingTime % 60));
               $AdditionalTime                          = $r->AdditionalTime;
               if($AdditionalTime == ''){
                  $row                                     = array();
                  $row[]                                   = $r->TaskName;
                  $row[]                                   = $r->Count;
                  $row[]                                   = $EstimatedTimeinHours ;
                  if($r->Note != "") 
                  {
                  $action                                   = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="displayNotes(\''.$r->Note.'\')" href="#" class="btn btn-success btn-xs purple"><i class="fa fa-edit"></i> Note</a>&nbsp';
                  $row[]                                    = $CurrespondingTimeinHours.$action;
                  }
                  else{
                    $action                                 = $CurrespondingTimeinHours ;
                  }            
                  $row[]                                    = $action;
                  }
               else{
                  $AdditionalTimeinHours                    = sprintf('%02d',intdiv($AdditionalTime, 60)) .':'. ( sprintf('%02d',$AdditionalTime % 60));
                  $row                                      = array();
                  $row[]                                    = $r->TaskName.'<br>'.'('.('AdditionalTime').')';
                  $row[]                                    = $r->Count.'<br>'.'('.(1).')';
                  $row[]                                    = $EstimatedTimeinHours.'<br>'.'('.($AdditionalTimeinHours).')';
                  if($r->Note != "") 
                  {
                  $action  = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="displayNotes(\''.$r->Note.'\')" href="#" class="btn btn-success btn-xs purple"><i class="fa fa-edit"></i> Note</a>&nbsp';
                  $row[]                                    = $CurrespondingTimeinHours.$action.'<br>'.'('.($AdditionalTimeinHours).')';
                  }
                  else
                  {
                    $action                                 = $CurrespondingTimeinHours.'<br>'.'('.($AdditionalTimeinHours).')' ;
                  }            
                  $row[]                                    = $action;
                  }
                $data[]                                     = $row;
            }  

           }                

          $output = array(
                 "draw"             => $draw,
                 "recordsTotal"     => $query->num_rows(),
                 "recordsFiltered"  => $query->num_rows(),
                 "data"             => $data
            );
          echo json_encode($output); 
}
// public function num_rows(){
//         $table='work_tb';
//         $where ="'RecordStatus' => 1";
//         $groupBy='WorkDate';
//         return $this->DatabaseModel->GetTotalRowsJoin($table,$Where,'','',$groupBy);
// }
}