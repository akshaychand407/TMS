<?php
class TaskModel extends CI_Model {
function __construct(){
parent::__construct(); 
$this->load->model('DatabaseModel');

}
public function get_Task($TeamName)
{
    extract($this->input->post('search'), EXTR_PREFIX_SAME, "wddx"); 
    $search        =    $value ? $value : null;
    if($search) 
    {
    $search   = array('task_tb.TaskName' => $search,'team_tb.TeamName' => $search,'task_tb.EstimatedTime' => $search);
     }
    if (!empty($search)) 
    {
    $this->db->group_start();
    $this->db->or_like($search);
    $this->db->group_end();
    }
    $select       = 'task_tb.Id,
                     task_tb.TaskName,
                     team_tb.TeamName,
                     task_tb.EstimatedTime';
    if($TeamName =='')
    {
      $where        = array('task_tb.RecordStatus'=>1);
    }
    else if($TeamName !='')
    {
    $this->db->where('task_tb.TeamName',$TeamName);
      $where        = array('task_tb.TeamName'=>$TeamName);
      $where        = array('task_tb.RecordStatus'=>1);
    }
     $join   = array(
        array('table'   =>  'team_tb' ,
            'condition' =>  'team_tb.Id = task_tb.TeamName',
            'jointype'  =>  '' 
        )
    );
    return $this->DatabaseModel->WRSFetchAllByJoin('task_tb',$select,$join,$where);        
}
function AddTask($id = '')    
    {
      $TaskName                    = $this->input->post('TaskName');
      $TeamName                    = $this->input->post('TeamName');
      $EstimatedTime               = $this->input->post('EstimatedTime');
      $this->db->where('TaskName',$TaskName);
      $this->db->where('TeamName',$TeamName);
      $this->db->where('EstimatedTime',$EstimatedTime);
      $this->db->where('RecordStatus',1);
      $query = $this->db->get('task_tb');
      if($query->num_rows()){
          $output = "Data Alread Exist";
          echo json_encode($output);
      }
      else{
        if($id){
                $updateData = array( 
                    'TaskName'                  => $TaskName,
                    'TeamName'                  => $TeamName,
                    'EstimatedTime'             => $EstimatedTime,
                    'LastModifiedDate'          => date('Y-m-d H:i:s'),
                    'LastModifiedBy'            => $this->session->Id,
                );   
            $this->db->where('Id',$id);
            $this->db->update('task_tb', $updateData);
            $output = "Data Updated";
            echo json_encode($output);

        }
        else 
        {
            $postData = array(
                    'TaskName'                  => $TaskName,
                    'TeamName'                  => $TeamName,
                    'EstimatedTime'             => $EstimatedTime,
                    'CreatedDate'               => date('Y-m-d H:i:s'), 
                    'CreatedBy'                 => $this->session->Id,  
                    'LastModifiedDate'          => date('Y-m-d H:i:s'),
                    'LastModifiedBy'            => $this->session->Id,
                );     
            $insert = $this->db->insert('task_tb', $postData);
            $output = "Data Inserted";
            echo json_encode($output);                 
        }
      }
    } 
public function deleteTaskDetails($taskId){
$updateData=array('RecordStatus'=>0);
$this->db->where('Id',$taskId);
$this->db->update('task_tb',$updateData);
$output = "Data Deleted";
echo json_encode($output);
}   
public function Team()
      {
        $this->db->where('RecordStatus',1);
        $this->db->select('Id,TeamName'); 
        return $result = $this->db->get('team_tb');  
      }
}