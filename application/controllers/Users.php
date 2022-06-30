<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	function __construct(){
parent::__construct();
$this->load->model('UserModel');
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
          $data['mainContent'] = 'users';
          $this->load->view('layout/template',$data);
	  }
    }

public function showWork()
{ 
$Designation  =  $this->session->Designation;
$draw         = intval($this->input->get("draw"));
$start        = intval($this->input->get("start"));
$length       = intval($this->input->get("length"));
if($this->input->post('order')){  
      $tableCols    =   array("FirstName","LastName");
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
$userid       = $this->session->Id;
$designation  = $this->session->Designation;
$work         = $this->UserModel->employee($userid,$designation);
$data         = array();
foreach($work->result() as $r) 
           {
               $row    = array();
               $row[]  = $r->User;
               $action  =  '<a onclick="viewUsers('.$r->Id.',\''.$r->User.'\')" href="#" class="btn btn-success btn-xs purple"><i class="fa fa-eye" aria-hidden="true"></i></i></a>&nbsp;';
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
}
