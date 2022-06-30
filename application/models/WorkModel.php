<?php
class WorkModel extends CI_Model {
function __construct(){
parent::__construct();        
}
public function get_Work($TeamName,$TaskName,$Status)
{ 
   $id=$this->session->Id;
   extract($this->input->post('search'), EXTR_PREFIX_SAME, "wddx"); 
   $search        =    $value ? $value : null;
   if($search) 
   {
   $search   = array('work_tb.Note' => $search,'team_tb.TeamName' => $search,'work_tb.WorkDate' => $search,'task_tb.TaskName' => $search,'work_tb.Status' => $search,'work_tb.Count' => $search);
      }
   if (!empty($search)) 
   {
   $this->db->group_start();
   $this->db->or_like($search);
   $this->db->group_end();
   }
   $this->db->select('work_tb.Id,
                      work_tb.WorkDate,
                      team_tb.TeamName, 
                      task_tb.TaskName,
                      work_tb.Count,
                      work_tb.Status,
                      work_tb.Note');
    if($TeamName =='' && $TaskName =='' && $Status =='')
       {
        $this->db->where('work_tb.CreatedBy',$id);
       }
    else if($TeamName =='' && $Status!='')
       {
        $this->db->where('work_tb.Status',$Status);
        $this->db->where('work_tb.CreatedBy',$id);
       }
    else if($TeamName !='' && $Status == '')
       {
        $this->db->where('work_tb.Team',$TeamName);
        $this->db->where('work_tb.CreatedBy',$id);
       }
    else if($TeamName !='' && $TaskName != '')
       {
        $this->db->where('work_tb.Task',$TaskName);
        $this->db->where('work_tb.Team',$TeamName);
       }
    else if($TeamName !='' && $Status != '')
       {
        $this->db->where('work_tb.Status',$Status);
        $this->db->where('work_tb.Team',$TeamName);
        $this->db->where('work_tb.CreatedBy',$id);
       }
    else if($TeamName !='' && $TaskName != '' && $Status != '')
       {
        $this->db->where('work_tb.Status',$Status);
        $this->db->where('work_tb.Task',$TaskName);
        $this->db->where('work_tb.Team',$TeamName);
       }
    $this->db->where('work_tb.RecordStatus',1);
    $this->db->from('work_tb'); 
    $this->db->join('team_tb', 'team_tb.Id = work_tb.Team');
    $this->db->join('task_tb', 'task_tb.Id = work_tb.Task');
    return $this->db->get();
}
function AddWork($id = '')    
    {
      $WorkDate                  = $this->input->post('WorkDate');
      $TeamName                  = $this->input->post('TeamName');
      $TaskName                  = $this->input->post('TaskName');
      $Count                     = $this->input->post('Count');
      $CurrespondingTime         = $this->input->post('CurrespondingTime');
      $Note                      = $this->input->post('Note');
      $AdditionalTime            = $this->input->post('AdditionalTime');
      $Status                    = $this->input->post('WorkStatus');
      $this->db->where('WorkDate',$WorkDate);
      $this->db->where('Team',$TeamName);
      $this->db->where('Task',$TaskName);
      $this->db->where('Count',$Count);
      $this->db->where('CurrespondingTime',$CurrespondingTime);
      $this->db->where('Note',$Note);
      $this->db->where('AdditionalTime',$AdditionalTime);
      $this->db->where('Status',$Status);
      $this->db->where('RecordStatus',1);
      $query = $this->db->get('work_tb');
      if($query->num_rows()){
          $output = "Data Alread Exist";
          echo json_encode($output);
      }
      else{
        if($id){
                $updateData = array( 
                    'WorkDate'                  => $WorkDate,
                    'Team'                      => $TeamName,
                    'Task'                      => $TaskName,
                    'Count'                     => $Count,
                    'CurrespondingTime'         => $CurrespondingTime,
                    'Note'                      => $Note,
                    'AdditionalTime'            => $AdditionalTime,
                    'Status'                    => $Status,
                    'LastModifiedBy'            =>  $this->session->Id,
                    'LastModifiedDate'          =>  date('Y-m-d H:i:s'),
                );
                $this->db->where('Id',$id);
                $this->db->update('work_tb', $updateData);
                $output = "Data Updated";
                echo json_encode($output);   
        }
        else 
        {
            $postData = array( 
                    'WorkDate'                  => $WorkDate,
                    'Team'                      => $TeamName,
                    'Task'                      => $TaskName,
                    'Count'                     => $Count,
                    'CurrespondingTime'         => $CurrespondingTime,
                    'Note'                      => $Note,
                    'AdditionalTime'            => $AdditionalTime,
                    'Status'                    => $Status,
                    'CreatedDate'               =>  date('Y-m-d H:i:s'), 
                    'CreatedBy'                 =>  $this->session->Id,  
                    'LastModifiedDate'          =>  date('Y-m-d H:i:s'),
                    'LastModifiedBy'            =>  $this->session->Id,
                );      
            $insert = $this->db->insert('work_tb', $postData);
            $output = "Data Inserted";
            echo json_encode($output);                 
        }
        if($insert) 
            return true;
        else 
            return false;
      }  
    }  
public function Team()
      {
        $this->db->where('RecordStatus',1);
        $this->db->select('Id,TeamName'); 
        $q = $this->db->get('team_tb');  
        return $response = $q->result_array();  
      }
public function getTeamTask($postData){
    $response = array();
    // Select record
    $this->db->select('Id,TaskName');
    $this->db->where('TeamName', $postData);
    $q = $this->db->get('task_tb');
    return $response = $q->result_array();
  }
public function getestimatedTime($postData){
    $response = array();
    // Select record
    $this->db->select('EstimatedTime');
    $this->db->where('Id', $postData);
    $q = $this->db->get('task_tb');
    return $response = $q->row();
  }
public function deleteWorkDetails($workId){
$updateData=array('RecordStatus'=>0);
$this->db->where('Id',$workId);
$this->db->update('work_tb',$updateData);
$output = "Data Deleted";
echo json_encode($output);
}
}