<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApproveWork extends CI_Controller {
	function __construct(){
parent::__construct();
$this->load->model('ApproveWorkModel');
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
          $data['mainContent'] = 'approvework';
          $data['User']=$this->ApproveWorkModel->User();
          $this->load->view('layout/template',$data);
	 }
   }


public function getTeamTask(){ 
    $postData = $this->input->post('team');    
    $data = $this->WorkModel->getTeamTask($postData);
    echo json_encode($data); 
  }
public function showWork()
{ 
$Designation  =  $this->session->Designation;
$draw = intval($this->input->get("draw"));
$start = intval($this->input->get("start"));
$length = intval($this->input->get("length"));
if($this->input->post('order')){  
      $tableCols    =   array("WorkDate","Team" ,"Task","Count","WorkStatus","FirstName","LastName","EstimatedTime");
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
$User =$this->input->post('User');
$UserId =$userid       =  $this->session->Id;;
$work = $this->ApproveWorkModel->get_Work($TeamName,$TaskName,$User,$userid);
$data = array();
foreach($work->result() as $r) 
           {
               $originalDate = $r->WorkDate;
               $newDate = date("d-m-Y", strtotime($originalDate));
               $EstimatedTime = $r->EstimatedTime;
               $EstimatedTimeinHours      = sprintf('%02d',intdiv($EstimatedTime, 60)) .':'. ( sprintf('%02d',$EstimatedTime % 60));
               $row    = array();
               $row[]  =  "<input type='checkbox' class = 'checkbox' name='checkbox' id='checkbox' value='$r->Id'>";
               $row[]  = $newDate;
               $row[]  = $r->User;
               $row[]  = $r->TeamName;
               $row[]  = $r->TaskName.'('.($EstimatedTimeinHours).')';
               $row[]  = $r->Count;
            $action = '<a onclick="aproveWork('.$r->Id.')" href="#" class="btn btn-success btn-xs purple"><i class="fa fa-edit"></i>Approve</a>&nbsp';
            $action .= '<a onclick="rejectWork('.$r->Id.')" href="#" class="btn btn-danger btn-xs purple"><i class="fa fa-trash-o"></i>Reject</a>&nbsp';
            if($r->Note != ''){
            $action   .=  '<a onclick="displayNotes(\''.$r->Note.'\')" href="#" class="btn btn-sm btn-info btn-xs black"><i class="fa fa-edit"></i></a>&nbsp;';
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
}
public function approveWork() {
$workId = $this->input->post('Workid');
echo $result = $this->ApproveWorkModel->approveWork($workId);
}
public function rejectWork() {
$workId      = $this->input->post('Workid');
echo $result = $this->ApproveWorkModel->rejectWork($workId);
}
}