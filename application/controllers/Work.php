<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Work extends CI_Controller {
	function __construct(){
parent::__construct();
$this->load->model('DatabaseModel');
$this->load->model('WorkModel');
$Designation  =  $this->session->Designation;
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
          $data['Team']=$this->WorkModel->Team();
          $data['mainContent'] = 'work';
          $this->load->view('layout/template',$data);
	    }
}
  public function getTeamTask(){ 
    $postData = $this->input->post('team');    
    $data = $this->WorkModel->getTeamTask($postData);
    echo json_encode($data); 
  }
  public function getestimatedTime(){ 
    $postData = $this->input->post('task');    
    $data = $this->WorkModel->getestimatedTime($postData);
    echo json_encode($data); 
  }
public function showWork()
{ 
$Designation  =  $this->session->Designation;
$draw = intval($this->input->get("draw"));
$start = intval($this->input->get("start"));
$length = intval($this->input->get("length"));
if($this->input->post('order')){  
      $tableCols    =   array("WorkDate","Team" ,"Task","Count","WorkStatus","Note");
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
$TeamName = $this->input->post('TeamName');
$TaskName =$this->input->post('TaskName');
$Status =$this->input->post('Status');
$work = $this->WorkModel->get_Work($TeamName,$TaskName,$Status);
$data = array();
foreach($work->result() as $r) 
           {
               $originalDate = $r->WorkDate;
               $Date = date("d-m-Y", strtotime($originalDate));
               If($r->Status==0){
                $Status = "Pending";
               }
               elseif ($r->Status==1) {
                 $Status = "Approved";
               }
               elseif ($r->Status==2) {
                 $Status = "Rejected";
               }
               $row    = array();
               $row[]  = $Date;
               $row[]  = $r->TeamName;
               $row[]  = $r->TaskName;
               $row[]  = $r->Count;
               $row[]  = $Status;
               $row[]  = $r->Note;
               if($Designation == "Head of Operation")
               {
            $action = '<a onclick="editWork('.$r->Id.')" href="#" class="btn btn-success btn-xs purple"><i class="fa fa-edit"></i> Edit</a>&nbsp';
            $action   .=  '<a onclick="deleteWork('.$r->Id.')" href="#" class="btn btn-danger btn-xs black"><i class="fa fa-trash-o"></i> Delete</a>&nbsp;';
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
"recordsTotal" => $work->num_rows(),
"recordsFiltered" => $work->num_rows(),
"data" => $data
);
echo json_encode($output);
// exit();
}
public function saveWork() {
		$id = $this->input->post('hiddenId');
		if($id <> '') {

		echo $result=$this->WorkModel->AddWork($id);
	   }
	   else
	     {
		echo $result=$this->WorkModel->AddWork();
	     }
    }
public function deleteWorkData() {
$workId      = $this->input->post('Workid');
echo $result = $this->WorkModel->deleteWorkDetails($workId);
}	
public function showWorkInformation() {
$id 		   = $this->input->post('hiddenId');
$result    = $this->db->get_where('work_tb', array('Id' => $id));
if($result->num_rows()>0) {
$result = $result->row(); 
$data   = array(
'WorkDate' 	              => $result->WorkDate,
'TeamName'                => $result->Team,
'TaskName'      		      => $result->Task,
'Count' 	                => $result->Count,
'Note' 	                  => $result->Note,
'CurrespondingTime'       => $result->CurrespondingTime,
'AdditionalTime'          => $result->AdditionalTime,
'Status'      		        => $result->Status
);  
// $this->load->view->feedbackform($data);
echo json_encode($data);
// return $result;
}
else {
echo json_encode(array('status'=>0,'message'=>'Error in Processing'));
}

}
}