<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Team extends CI_Controller {
	function __construct(){
parent::__construct();
$this->load->model('DatabaseModel');
$this->load->model('TeamModel');
}
	public function index()
	{
   $logged_in = $this->session->userdata('logged_in');
      if($logged_in != TRUE || empty($logged_in))
      {
          $this->session->set_flashdata('error', 'Login To Continue');
          redirect(base_url() . 'Login/index'); 
      }
      else
      {  
		      $data['mainContent'] = 'team';
          $data['TeamLeader']=$this->TeamModel->TeamLeader();
          $data['TeamManager']=$this->TeamModel->TeamManager();
          $this->load->view('layout/template',$data);
	    }
  }
public function showTeam()
{
// Datatables Variables
$Designation  =  $this->session->Designation;
$draw = intval($this->input->get("draw"));
$start = intval($this->input->get("start"));
$length = intval($this->input->get("length"));
$TeamLeader = $this->input->post('TeamLeader');
$TeamManager = $this->input->post('TeamManager');
if($this->input->post('order')){  
      $tableCols    =   array("TeamName","TeamLeader" ,"TeamManager");
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
$team = $this->TeamModel->get_Team($TeamLeader,$TeamManager);
$data = array();
foreach($team->result() as $r) 
           {
               $row    = array();
               $row[]  = $r->TeamName;
               $row[]  = $r->TeamLeader;
               $row[]  = $r->TeamManager;
               if($Designation == "Head of Operation")
               {
            $action = '<a onclick="editTeam('.$r->Id.')" href="#" class="btn btn-success btn-xs purple"><i class="fa fa-edit"></i> Edit</a>&nbsp';
            $action   .=  '<a onclick="deleteTeam('.$r->Id.')" href="#" class="btn btn-danger btn-xs black"><i class="fa fa-trash-o"></i> Delete</a>&nbsp;';
             $row[]  =$action;
           }
           else
           {
             $action  ='' ;
           }
           $row[]  = $action;
           $data[] = $row;
           }
$output = array(
"draw" => $draw,
"recordsTotal" => $team->num_rows(),
"recordsFiltered" => $team->num_rows(),
"data" => $data
);
echo json_encode($output);
}
public function saveTeam() {
	
		$id = $this->input->post('hiddenId');
		if($id <> '') {

		echo $result=$this->TeamModel->AddTeam($id);
	   }
	   else
	     {
		echo $result=$this->TeamModel->AddTeam();
	     }
    }
public function deleteTeamData() {
$teamId      = $this->input->post('Teamid');
echo $result = $this->TeamModel->deleteTeamDetails($teamId);
}	
public function showTeamInformation() {
$id 		   = $this->input->post('hiddenId');
$result    = $this->db->get_where('team_tb', array('Id' => $id));
if($result->num_rows()>0) {
$result = $result->row(); 
$data   = array(
'TeamName' 	              => $result->TeamName,
'TeamLeader'              => $result->TeamLeader,
'TeamManager'      		    => $result->TeamManager
);  
echo json_encode($data);
}
else {
echo json_encode(array('status'=>0,'message'=>'Error in Processing'));
}

}
} 