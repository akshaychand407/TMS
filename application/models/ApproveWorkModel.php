<?php
class ApproveWorkModel extends CI_Model {
function __construct(){
parent::__construct();        
}
public function User()
      {
        $this->db->where('RecordStatus',1);
        $this->db->select('Id,concat(FirstName," ",LastName)as User'); 
        return $result = $this->db->get('users_tb');  
      }
public function get_Work($TeamName,$TaskName,$User,$UserId)
{
   extract($this->input->post('search'), EXTR_PREFIX_SAME, "wddx"); 
   $search        =    $value ? $value : null;
   if($search) 
   {
   $search   = array('users_tb.FirstName' => $search,'users_tb.LastName' => $search,'team_tb.TeamName' => $search,'work_tb.WorkDate' => $search,'task_tb.TaskName' => $search,'task_tb.EstimatedTime' => $search,'work_tb.Count' => $search);
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
                      task_tb.EstimatedTime,
                      work_tb.Count,
                      concat(FirstName," ",LastName)as User,
                      work_tb.Note,
                      work_tb.CreatedBy');
    if($TeamName =='' && $TaskName =='' && $User =='')
       {
        $this->db->like('users_tb.Managers',$UserId);
       }
    else if($TeamName =='' && $User!='')
       {
        $this->db->where('work_tb.CreatedBy',$User);
       }
    else if($TeamName !='' && $User == '')
       {
        $this->db->where('work_tb.Team',$TeamName);
       }
    else if($TeamName !='' && $TaskName != '')
       {
        $this->db->where('work_tb.Task',$TaskName);
        $this->db->where('work_tb.Team',$TeamName);
       }
    else if($TeamName !='' && $User != '')
       {
        $this->db->where('work_tb.CreatedBy',$User);
        $this->db->where('work_tb.Team',$TeamName);
       }
    else if($TeamName !='' && $TaskName != '' && $User != '')
       {
        $this->db->where('work_tb.CreatedBy',$User);
        $this->db->where('work_tb.Task',$TaskName);
        $this->db->where('work_tb.Team',$TeamName);
       }
    $this->db->where('work_tb.Status',0);
    $this->db->where('work_tb.RecordStatus',1);
    $this->db->from('work_tb'); 
    $this->db->join('team_tb', 'team_tb.Id = work_tb.Team');
    $this->db->join('task_tb', 'task_tb.Id = work_tb.Task');
    $this->db->join('users_tb','users_tb.Id = work_tb.CreatedBy');
    return $this->db->get();
}
public function approveWork($workId){
$updateData=array('Status'=>1);
$this->db->where_in('Id',$workId);
$this->db->update('work_tb',$updateData);
$output = "Data Approved";
echo json_encode($output);
}
public function rejectWork($workId){
$updateData=array('Status'       =>2,
                   'RejectNote'  => $this->input->post('rejectNote')
                   );
$this->db->where('Id',$workId);
$this->db->update('work_tb',$updateData);
$output = "Data Rejected";
echo json_encode($output);
}
public function Note($Id)
      {
        $this->db->where('Id',$Id);
        $this->db->select('Note'); 
        $q = $this->db->get('work_tb');  
        return $response = $q->result_array();  
      }
}