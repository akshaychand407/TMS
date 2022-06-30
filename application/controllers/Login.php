<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
          ob_start();
parent::__construct();
$this->load->model('LoginModel');
}
    function __destruct() {
      if ($this->session->userdata('logged_in') == TRUE) 
           {
             redirect(base_url() . 'Dashboard/index'); 
           }
}
	public function index()
	{
		$data['MainContent'] 		= 	'Login';	
		$this->load->view('template',$data);
	}
	// function login_validation()  
 //      {  
          
 //           $this->form_validation->set_rules('Email', 'Email', 'trim|required|valid_email');  
 //           $this->form_validation->set_rules('Password', 'Password', 'required');  

 //           if($this->form_validation->run())  
 //           {    
 //                $Email = $this->input->post('Email');  
 //                $Password = $this->input->post('Password'); 
 //                // print_r(password_hash($Password, PASSWORD_DEFAULT));die();
 //                //model function  
 //                $query=$this->LoginModel->login($Email, $Password);  
 //                if($query->num_rows()>0)  
 //                {   
 //                      $result = $query->row(); 
 //                        $data   = array(
 //                                 'Id'             => $result->Id,
 //                                 'Designation'    => $result->Designation,
 //                                 'User'           => $result->User,
 //                                 'logged_in'      => TRUE);
 //                        $this->session->set_userdata($data);  
 //                     redirect(base_url() . 'Dashboard/index');  
 //                }  
 //                else  
 //                {  
 //                     $this->session->set_flashdata('error', 'Invalid Email and Password');  
 //                     redirect(base_url() . 'Login/index');  
 //                }  
 //           }  
           
 //      } 

      function login_validation()   {

          $table              =  'users_tb';
          $userName           =    $this->input->post('Email');
          if($userName == '' || $this->input->post('Password') == ''){
               $data = array(
                    'error' => "Please fill username and password"
               );
               $this->session->set_userdata($data);
               redirect(base_url() . 'Login/index'); 
          }
          
          $failedAttempts          =   $this->LoginModel->FailedAttempsValidate($table);
          if( $failedAttempts >= FAILED_ATTEMPTS_MAX ){
               $data = array(
                    'error' => "Your account hasbeen blocked! Please contact administrator to unblock account"
               );
               $this->session->set_userdata($data);
               redirect(base_url() . 'Login/index');
          }
          $query         =   $this->LoginModel->ValidateBcryptWithoutGmail($table,$failedAttempts);
          
          if($query)     {

               $query         =    $query->row();
               // $rolesWhere =  array('UserId' => $query->Id);
               // $joins                        = array(
               //      array('table'       => 'role',
               //           'condition'    => 'role.id = users_roles.RoleId',
               //           'jointype'               => '' ),
               //      );
               // $rolesResult=  $this->DatabaseModel->WRSFetchAllByJoin('users_roles','role.roleId',$joins,$rolesWhere)->result_array();


               // $roles         =    array_column($rolesResult, 'roleId');
               $data          =    array(
                                 'Id'             => $query->Id,
                                 'Designation'    => $query->Designation,
                                 'User'           => $query->FirstName.($query->LastName),
                                 'logged_in'      => TRUE);
               $this->session->set_userdata($data);

               // print_r($this->session->userdata());
               // die();
               // $loginLog      =   $this->LoginModel->LoginLog('logs','S');
               // if($this->input->post('hiddenPath')){//MEN-597 Direct URL for Contractor. By Nithin
               //      redirect($this->input->post('hiddenPath'));
               // }else{
                     redirect(base_url() . 'Dashboard/index');  
               // }    
          }else {
               // $loginLog      =   $this->LoginModel->LoginLog('logs','F',1,$userName);
               $Data = array(
                    'error' => "Username and Password doesn't match"
               );
               $this->session->set_userdata($Data);
               redirect(base_url() . 'Login/index');
          }
     }   
     function logout() {

          $path = base_url() . 'Login/index';
          $this->load->driver('cache');
          $this->session->sess_destroy();
          $this->cache->clean();
          echo '<script "text/javascript"> sessionStorage.clear(); </script>';
          ob_clean();
          $data = array(
               'error' => "You've successfully logged out",
               'logged_in'      => FALSE
          );
          $this->session->set_userdata($data);
          redirect($path);
     }
   
}