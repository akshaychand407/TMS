<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
parent::__construct();
$this->load->model('DashboardModel');
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
          $id = $this->input->post('userhiddenid');
          $username = $this->input->post('usernamehiddenid');
          $data['userId']=$id;
          $data['username']=$username;
		      $data['mainContent'] = 'dashboard';
          $this->load->view('layout/template',$data);
      }
	}

public function showDashboard(){
  $UserId=$this->input->post('userId');
  $Year=$this->input->post('year');
  $Month=$this->input->post('month');
  // print_r($UserId);die('uhur');
  echo $this->DashboardModel->groupAllDate($UserId,$Month,$Year);
}

public function showDashboardDetails()
{ 
$userId = $this->input->post('userId');
$date = $this->input->post('date');
$Date                       = date("Y-m-d", strtotime($date));
// echo($date);die('ijf');
echo $this->DashboardModel->getDashboarddetails($userId,$Date);
}

public function changePassword() {
    if($this->input->post()) {
      $this->load->model('UserModel');
      $query = $this->UserModel->ChangePassword($this->input->post('hiddenId'));
      if($query) {
        echo json_encode(array('success' => 1,'message'=>'User changed password' ));
      }
      else {
        echo json_encode(array('message'=>'Failed to change'));
      }
      exit;
    }
  }
}