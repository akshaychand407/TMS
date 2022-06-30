<?php
class UserModel extends CI_Model {
    public function ChangePassword($id) {

	  $newCredential = password_hash($this->input->post('newCredential'),PASSWORD_DEFAULT);
	  $newCredentialVerify = password_hash($this->input->post('newCredentialVerify'),PASSWORD_DEFAULT);
	  $where = array('Id' => $id);
	  $this->load->model('DatabaseModel');
	   $userDetails = $this->DatabaseModel->FetchAllBy('users_tb','Password',$where)->result();
	   $oldPassword = $userDetails[0]->Password;

	   if(isset($oldPassword)) {
		
		$updateData = array('Password'   => $newCredentialVerify);	
			$update = $this->db->update('users_tb',$updateData,$where);   
	}
	if($update) return true;
	else {
		return false;
	}

	}
	public function employee($userid,$designation){
		   extract($this->input->post('search'), EXTR_PREFIX_SAME, "wddx"); 
            $search        =    $value ? $value : null;
           if($search) 
            {
            $search   = array('FirstName' => $search,'LastName' => $search);
             }
            if (!empty($search)) 
            {
           $this->db->group_start();
           $this->db->or_like($search);
           $this->db->group_end();
           }
		   $this->db->where('RecordStatus',1);
		   if($designation != 'Head of Operation'){
           $this->db->like('Managers',','.$userid);
           }
           $this->db->select(' Id,concat(FirstName," ", LastName) as User');      
           return $this->db->get('users_tb');
	}
}