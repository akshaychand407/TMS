<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {
	function __construct(){
parent::__construct();
$this->load->model('DatabaseModel');
$this->load->model('TaskModel');
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
         $data['Team']=$this->TaskModel->Team();
         $data['mainContent'] = 'task';
         $this->load->view('layout/template',$data);
	    }
  }
public function showTask()
{
// Datatables Variables
$Designation  =  $this->session->Designation;
$draw = intval($this->input->get("draw"));
$start = intval($this->input->get("start"));
$length = intval($this->input->get("length"));
if($this->input->post('order')){  
      $tableCols    =   array("TaskName","TeamName" ,"EstimatedTime");
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
$task = $this->TaskModel->get_Task($TeamName);
$data = array();
foreach($task->result() as $r) 
           {   
               $EstimatedTime = $r->EstimatedTime;
               $EstimatedTimeinHours      = sprintf('%02d',intdiv($EstimatedTime, 60)) .':'. ( sprintf('%02d',$EstimatedTime % 60));
               $row    = array();
               $row[]  = $r->TaskName;
               $row[]  = $r->TeamName;
               $row[]  = $EstimatedTimeinHours;
               if($Designation == "Head of Operation")
               {
                 $action = '<a onclick="editTask('.$r->Id.')" href="#" class="btn btn-success btn-xs purple"><i class="fa fa-edit"></i> Edit</a>&nbsp';
                 $action   .=  '<a onclick="deleteTask('.$r->Id.')" href="#" class="btn btn-danger btn-xs black"><i class="fa fa-trash-o"></i> Delete</a>&nbsp;';
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
"recordsTotal" => $task->num_rows(),
"recordsFiltered" => $task->num_rows(),
"data" => $data
);
echo json_encode($output);
// exit();
}
public function saveTask() {
		 	
	
		$id = $this->input->post('hiddenId');
		if($id <> '') {

		echo $result=$this->TaskModel->AddTask($id);
	   }
	   else
	     {
		echo $result=$this->TaskModel->AddTask();
	     }
    }
public function deleteTaskData() {
$taskId      = $this->input->post('Taskid');
echo $result = $this->TaskModel->deleteTaskDetails($taskId);
}	
public function showTaskInformation() {
$id 		  = $this->input->post('hiddenId');
$result    = $this->db->get_where('Task_tb', array('Id' => $id));
if($result->num_rows()>0) {
$result = $result->row(); 
$data   = array(
'TaskName' 	                  => $result->TaskName,
'TeamName'                    => $result->TeamName,
'EstimatedTime'      		  => $result->EstimatedTime
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