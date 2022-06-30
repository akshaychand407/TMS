<?php
class TeamModel extends CI_Model {
function __construct(){
parent::__construct();
$this->load->model('DatabaseModel');
}
public function get_Team($TeamLeader,$TeamManager)
{
    extract($this->input->post('search'), EXTR_PREFIX_SAME, "wddx"); 
    $search        =    $value ? $value : null;
    if($search) 
    {
    $search   = array('TeamName' => $search,'TeamLeader' => $search,'TeamManager' => $search);
     }
    if (!empty($search)) 
    {
    $this->db->group_start();
    $this->db->or_like($search);
    $this->db->group_end();
    }
    $this->db->select('team_tb.TeamName as TeamName,
                     team_tb.Id,
                     concat(U1.FirstName," ", U1.LastName)as TeamLeader, 
                     concat(U2.FirstName," ", U2.LastName)as TeamManager');
    if($TeamLeader =='' && $TeamManager =='')
    {
        $this->db->where('team_tb.RecordStatus',1);
    }
    else if($TeamLeader =='' && $TeamManager!='')
       {
        $this->db->where('team_tb.RecordStatus',1);
        $this->db->where('team_tb.TeamManager',$TeamManager);
       }
    else if($TeamLeader !='' && $TeamManager == '')
       {
        $this->db->where('team_tb.RecordStatus',1);
        $this->db->where('team_tb.TeamLeader',$TeamLeader);

       }
    else if($TeamLeader !='' && $TeamManager != '')
       {
        $where        = array('team_tb.TeamManager'=>$TeamManager);
        $where        = array('team_tb.TeamLeader'=>$TeamLeader);
        $this->db->where('team_tb.TeamManager',$TeamManager);
        $this->db->where('team_tb.TeamLeader',$TeamLeader);
        $this->db->where('team_tb.RecordStatus',1);
       }
    $this->db->from('team_tb'); 
    $this->db->join('users_tb as U1', 'U1.Id = team_tb.TeamLeader');
    $this->db->join('users_tb as U2', 'U2.Id = team_tb.TeamManager');
    return $this->db->get();
}
function AddTeam($id = '')    
    {
      $TeamName                  = $this->input->post('TeamName');
      $TeamLeader                = $this->input->post('TeamLeader');
      $TeamManager               = $this->input->post('TeamManager');
      $this->db->where('TeamName',$TeamName);
      $this->db->where('TeamLeader',$TeamLeader);
      $this->db->where('TeamManager',$TeamManager);
      $this->db->where('RecordStatus',1);
      $query = $this->db->get('team_tb');
      if($query->num_rows()){
          $output = "Data Alread Exist";
          echo json_encode($output);
      }
      else{

        if($id){
                $updateData = array( 
                    'TeamName'                  => $TeamName,
                    'TeamLeader'                => $TeamLeader,
                    'TeamManager'               => $TeamManager,
                    'LastModifiedDate'          =>  date('Y-m-d H:i:s'),
                    'LastModifiedBy'            =>  $this->session->Id,
                );   
                $this->db->where('Id',$id);
                $this->db->update('team_tb', $updateData);
                $output = "Data Updated";
                echo json_encode($output);
        }
        else 
        {
            $postData = array(
                    'TeamName'                  => $TeamName,
                    'TeamLeader'                => $TeamLeader,
                    'TeamManager'               => $TeamManager,
                    'CreatedDate'               =>  date('Y-m-d H:i:s'), 
                    'CreatedBy'                 =>  $this->session->Id,  
                    'LastModifiedDate'          =>  date('Y-m-d H:i:s'),
                    'LastModifiedBy'            =>  $this->session->Id,
                );     
            $insert = $this->db->insert('team_tb', $postData);
            $output = "Data Inserted";
            echo json_encode($output);                 
        }
    } 
 }   
public function deleteTeamDetails($teamId){
$updateData=array('RecordStatus'=>0);
$this->db->where('Id',$teamId);
$this->db->update('team_tb',$updateData);
$output = "Data Deleted";
echo json_encode($output);
}
public function TeamLeader()
      {
        $this->db->where('RecordStatus',1);
        $this->db->where('Designation',"Team Leader");
        $this->db->select(' Id,concat(FirstName," ", LastName) as TeamLeaderName'); 
        $result = $this->db->get('users_tb');  
        return $result;
      }
public function TeamManager()
      {
        $this->db->where('RecordStatus',1);
        $this->db->where('Designation',"Team Manager");
        $this->db->select(' Id,concat(FirstName," ", LastName) as TeamManagerName'); 
        $result = $this->db->get('users_tb');  
        return $result;
      }
}