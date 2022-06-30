<?php

									
class DatabaseModel extends CI_Model{
	
	//private $tbl_parent= 'logins';
	function __construct(){
			parent::__construct();
			$this->load->database();				
	}

	function FetchAll($table = '',$select='*'){

 		$this->db->select($select);
 		if(!in_array($table,array('role','expensetypemaster'))){
        	$this->db->where('RecordStatus', 1); // Default for all table
    	}
 		return $this->db->get($table);
 	}


	function FetchAllLike($table = '',$select='*',$like = ''){

		$this->db->select($select);
		$this->db->where('RecordStatus',1); // Default for all table
		if($like !=''){
			$this->db->group_start();
				$this->db->or_like($like ,false, 'after');
			$this->db->group_end();
		}
		return $this->db->get($table);
	}    

  function FetchSingle($table,$field='',$where = '',$recordStatus = 1){

	$this->db->select($field); 
	if($where != ''){
		$this->db->where($where);
	}
	if($recordStatus == 1)
	  $this->db->where('RecordStatus',1);

	$result = $this->db->get($table);

	if($result->num_rows() == 1){
	  $result = $result->row();
	  return $result->$field;
	}else{
	  return false;
	}
  } 



  /*
	Function changed for the ticket MPM-160 - Contractor Search: Append first 3 digits of company name to contractor name
	Developer : Premjith
	Date : 12-03-2020
	To show company name along with contractor in contractor search box
	*/
  function FetchContractorLike($like = ''){

	//$select = "contractors.Id as Id,concat(contractors.ContractorFirstName,' ',contractors.ContractorLastName) as contractor,group_concat(companies.CompanyName) as company";
	$select = "contractors.Id as Id,concat(contractors.ContractorFirstName,' ',contractors.ContractorLastName) as contractor,companies.CompanyName as company";
	$this->db->select($select);

	$this->db->join('contracts', 'contractors.id = contracts.contractorid  and contracts.recordstatus = 1 and contracts.contractstatus = 1', 'left');
	$this->db->join('companies', 'companies.id = contracts.companyid', 'left');

	$this->db->where('contractors.RecordStatus',1); // Default for all table
	if($like !=''){
	  $this->db->group_start();
		$this->db->where( "CONCAT(TRIM(ContractorFirstName), ' ',TRIM(ContractorLastName)) LIKE $like OR CONCAT(TRIM(ContractorLastName), ' ',TRIM(ContractorFirstName)) LIKE $like");
	  $this->db->group_end();
	}
	
	$this->db->group_by('contractors.id');
	return $this->db->get('contractors');
  }



  // ----------------------------------------------------------------------------------------------------------------------
  
   function FetchSpouseLike($like = ''){

	
	$select = "spouse.Id as id,concat(spouse.SpouseFirstName,' ',spouse.SpouseLastName) as spouse";
	$this->db->select($select);

	$this->db->where('spouse.RecordStatus',1); // Default for all table
	if($like !=''){
	  $this->db->group_start();
		$this->db->where( "CONCAT(TRIM(SpouseFirstName), ' ',TRIM(SpouseLastName)) LIKE $like OR CONCAT(TRIM(SpouseLastName), ' ',TRIM(SpouseFirstName)) LIKE $like");
	  $this->db->group_end();
	}
	
	$this->db->group_by('spouse.id');
	return $this->db->get('spouse');
  }

 




  // ---------------------------------------------------------------------------------------------------------------------




  function GetContractorDataTable($table = '', $select = '*', $where =false, $limit = '', $offset = 0, $orderBy = '', $search = false) {

		$this->db->select($select);
		  if($table != 'users'){
			$this->db->where('RecordStatus', 1); // Default for all table
		}
	  
	   
		if (!empty($where)){
			$this->db->where($where);
		}
		if (!empty($orderBy) ) {
			$this->db->order_by($orderBy);
		}
		if (!empty($search)) {
			$this->db->group_start();
				  //$this->db->or_like($search);
		  $this->db->where( "CONCAT(TRIM(ContractorFirstName), ' ',TRIM(ContractorLastName)) LIKE $search OR CONCAT(TRIM(ContractorLastName), ' ',TRIM(ContractorFirstName)) LIKE $search OR TRIM(ContractorEmail) LIKE $search");
				$this->db->group_end();
		}
		if ($limit != '') {
			$this->db->limit($limit, $offset);
		}
		return $this->db->get($table);
	}  
	
  public function GetContractorTotalRows($table,$Where=null,$search=null) {
		$this->db->select("COUNT(*) as num");
		if($table != 'users'){
			$this->db->where('RecordStatus', 1); // Default for all table
		}
		if(!empty($Where)){
			 $this->db->where($Where);
		}
		if (!empty($search)) {
		  $this->db->group_start();
				  //$this->db->or_like($search);
		  $this->db->where( "CONCAT(TRIM(ContractorFirstName), ' ',TRIM(ContractorLastName)) LIKE $search OR CONCAT(TRIM(ContractorLastName), ' ',TRIM(ContractorFirstName)) LIKE $search OR TRIM(ContractorEmail) LIKE $search");
				$this->db->group_end();
		}
		$query = $this->db->get($table);
		if($query->num_rows() > 0)
			$result = $query->row();
		if (isset($result))
			return $result->num;
		return 0;
	}

	/* 	************** $WHERE SYNTAX **************

		$Where = array('name' => $name, 'title' => $title, 'status' => $status);
							OR
		$Where = "name='Joe' AND status='boss' OR status='active'"; 

		************** Order by SYNTAX **************

		$this->db->order_by('title DESC, name ASC'); */

	function FetchAllBy($table = '',$select='*',$where = '',$limit='',$offset = 0,$orderBy = '',$RecordStatus = 1,$groupBy = ''){

		$this->db->select($select);  
		if(!in_array($table,array('bankstatement_temp','bankstatement','users','uploadinvoicelist_temp','uploadinvoicelist'))){
			if($RecordStatus){
				$this->db->where('RecordStatus',1); // Default for all table
			}
		}
		if($table == 'bankstatement'){
			if($RecordStatus){
				$this->db->where('RECORD_STATUS',1); // Default for all table
			}
		}
		$this->db->where($where);
		if($orderBy != ''){
			$this->db->order_by($orderBy);
		}
		if($groupBy != ''){
			$this->db->group_by($groupBy);
		}
		if($limit != ''){
			return $this->db->get($table, $limit, $offset);
		}else{
			return $this->db->get($table);
		}  
	}

  function FetchAllByNotIn($table = '',$select='*',$where = '',$wherenot = '',$limit='',$offset = 0,$orderBy = ''){

	$this->db->select($select);
	if($where != ''){
	  $this->db->where($where);
	}
	if(count($wherenot['data'])){
	  $this->db->where_not_in($wherenot['field'],$wherenot['data']);
	}
	
	if($orderBy != ''){
	  $this->db->order_by($orderBy);
	}
	if($limit != ''){
	  return $this->db->get($table, $limit, $offset);
	}else{
	  return $this->db->get($table);
	}
  }

  function FetchAllByIn($table = '',$select='*',$where = '',$wherein = '',$limit='',$offset = 0,$orderBy = ''){

	$this->db->select($select);
	if($where != ''){
	  $this->db->where($where);
	}
	 if(count($wherein['data'])){
	  $this->db->where_in($wherein['field'],$wherein['data']);
	}
	
	if($orderBy != ''){
	  $this->db->order_by($orderBy);
	}
	if($limit != ''){
	  return $this->db->get($table, $limit, $offset);
	}else{
	  return $this->db->get($table);
	}
  }

   /*Fetch all By function for bypass record status */
	function WRSFetchAllBy($table = '',$select='*',$where = '',$limit='',$offset = 0,$orderBy = ''){

		$this->db->select($select);
		//$this->db->where('RecordStatus',1); // Default for all table
		if($where != ''){
	  $this->db->where($where);
	}
		if($orderBy != ''){
			$this->db->order_by($orderBy);
		}
		if($limit != ''){
			return $this->db->get($table, $limit, $offset);
		}else{
			return $this->db->get($table);
		}
	}
	/*Fetch all By function for bypass record status with join more than one table option */
	function WRSFetchAllByJoin($table = '', $select='*', $joins='',$where='',$limit = '', $offset = 0,$orderBy = '',$groupBy = '',$wherein = ''){

		$this->db->select($select);
		if (is_array($joins) && count($joins) > 0){
			$this->join($joins);
		}
		if($where != ''){
			$this->db->where($where);
		}	
		if (is_array($wherein) && count($wherein) > 0){
			$this->db->where_in($wherein['field'],$wherein['data']);
		}
		if($groupBy != ''){
			$this->db->group_by($groupBy);
		}
		if($orderBy != ''){
			$this->db->order_by($orderBy);
		}
		if($limit != ''){
			return $this->db->get($table, $limit, $offset);
		}else{
			return $this->db->get($table);
		}
	}

   /* Update all table through audit trail login system
	function AuditTrialUpdate($table='',$primaryKey='',$updateData = '',$where='',$userId = ''){

	 
		$params   = array($updateData,$table,$primaryKey);
		if(in_array('', $params)){

			return false;
		}
		$beforeUpdate   =  $this->WRSFetchAllBy($table,'*',$where)->row();
	  //echo $this->db->last_query();
		$update         =  $this->db->update($table, $updateData,$where);
	  // echo $this->db->last_query();
	  // die();
		$auditexclude   = $this->config->item('Audit_Trial_Exclude');
		
		if($update){
		  
			foreach ($updateData as $key => $value) {
						 //print_r($beforeUpdate->$key); exit;
				if(in_array($key,$auditexclude)){
					
					continue;
				}
				if(is_array($value)){

					$value = implode(',',$value);

				} 
		  // echo "up<br/>";
		  // print_r($updateData[$key]);
		  // echo "b4<br/>";
		  // print_r($beforeUpdate->$key);
		  // echo "end<br/>";
		  // exit;   
		  
				if(!isset($beforeUpdate->$key)) continue;
		  // var_dump($beforeUpdate->$key)  ;var_dump($updateData[$key])  ;exit;
					if($beforeUpdate->$key != $updateData[$key]){
					  
						// if($key == 'ContractorSector'){
						// 	die('here');
						// }
				  //var_dump("sss");exit;
						$insertData = array(
						 'UserId'    => ($userId != '')?$userId:$this->session->userId,
						 'TableName'    => $table,
						 'PrimaryKey'   => $beforeUpdate->$primaryKey,
						 'ColumnName'   => $key,
						 'OldValue'      => $beforeUpdate->$key,
						 'NewValue'      => $value,
						 'LastModifiedDate'  => date('Y-m-d H:i:s'),
						);
			  
						$insert   = $this->db->insert('audittrial',$insertData); 
					 }
			}
				return true;
		}else{
				return false;
		}
	}*/

	/* Update all table through audit trail login system*/
	function AuditTrialUpdate($table='',$primaryKey='',$updateData = '',$where='',$userId = ''){

		$params         =   array($updateData,$table,$primaryKey);
		if(in_array('', $params)){
			return false;
		}
		$beforeUpdate   =   $this->WRSFetchAllBy($table,'*',$where)->row();
		$update         =   $this->db->update($table, $updateData,$where);
		$auditexclude   =   $this->config->item('Audit_Trial_Exclude');
		
		if($update){
		  
			foreach ($updateData as $key => $value) {
				if(in_array($key,$auditexclude)){
					
					continue;
				}
				if(is_array($value)){

					$value = implode(',',$value);

				} 
			   // if(!isset($beforeUpdate->$key)) continue;
				if($beforeUpdate->$key != $updateData[$key]){
					$insertData                 =   array(
						'UserId'               =>  ($userId != '')?$userId:$this->session->userId,
						'TableName'            =>  $table,
						'PrimaryKey'           =>  $beforeUpdate->$primaryKey,
						'ColumnName'           =>  $key,
						'OldValue'             =>  $beforeUpdate->$key,
						'NewValue'             =>  $value,
						'LastModifiedDate'     =>  date('Y-m-d H:i:s'),
					);
					$insert   =     $this->db->insert('audittrial',$insertData); 
		  if(!$insert){
			log_message('error','CUSTOM ERROR: AUDIT TRIAL INSERTION FAILED, Query'.json_encode($this->db->last_query()));
		  }
		}
	  }
	  return true;
	}else{
	  log_message('error','CUSTOM ERROR: AUDIT TRIAL UPDATION FAILED, Query'.$lastQueryFailed);
	  return false;
	}
  }






	/* Checking the user is loged in or not*/
	function IsLoggedIn(){

		$user = $this->session->userdata();
	// MEN-597 Direct URL for Contractor. By Nithin  
	$redirect   = $this->uri->uri_string();
	$path     = 'auth/index';
	if($redirect){
	  $url    = substr($redirect, strrpos($redirect, '/' )+1);
	  if($url == 'SECOND_LOGIN'){
		$path = 'auth/index2/'.$redirect;
	  }else{
		$path = 'auth/index/'.$redirect;
	  }
	}
	// MEN-597 Direct URL for Contractor. By Nithin  Ends
		if(!isset($user['loggedIn'])){
			redirect($path);
		}
	}
  
   /* Set global variables by cheking it from post */
	function SetGlobals($data,$refresh = false,$ContractRefresh = false,$ContractorRefresh = false){
  

		if( ($this->input->post('CONTRACTORID') != '') || $ContractorRefresh){
			if(!$ContractorRefresh){
				$data['CONTRACTORID'] 		= 	$this->input->post('CONTRACTORID');	
			}
			if(!$ContractRefresh){
				$data['CONTRACTID'] 		= 	$this->input->post('CONTRACTID');	
			}
			$data['CONTRACTORFULLNAME'] 	= 	$this->input->post('CONTRACTORFULLNAME');
			$data['AGENTID']				=	$this->input->post('AGENTID');
			$data['COMPANYID']				=	$this->input->post('COMPANYID');
			$data['AGENCYNAME']				=	$this->input->post('AGENCYNAME');
			$data['COMAPNYNAME']			=	$this->input->post('COMAPNYNAME');
	  $data['CONTRACTORSTATUS']		=	$this->input->post('CONTRACTORSTATUS');
			$data['CONTRACTORCOMPANYTYPE']	=	$this->input->post('CONTRACTORCOMPANYTYPE');
			//PostIt Notes
	  $wherePostNote    = array('ContractorId' => $data['CONTRACTORID'],'Status'=> 1,'RecordStatus'=>1);
	  $postItNotes      =  $this->FetchAllBy('postitnotes','Notes,Field',$wherePostNote)->result();
	  $data['CONTRACTORPOSTITNOTES'] = $postItNotes;
			if($refresh){

				//get contactor name from data base for first selection of contractor
				$Where 						= 	array('Id' => $data['CONTRACTORID']);
				$result 					= 	$this->FetchAllBy('contractors','*',$Where)->result();
				$data['CONTRACTORFULLNAME'] =	$result[0]->ContractorFirstName." ".$result[0]->ContractorLastName;
		$data['CONTRACTORSTATUS']     		= 	$result[0]->ContractorStatus;
				$data['CONTRACTORCOMPANYTYPE']     	= 	$result[0]->ContractorCompanyType;
				//get contact details from data base for first selection of contract
				$joinContract 				= 	array(
					array('table' 			=> 	'agencies',
						'condition' 		=> 	'agencies.Id = contracts.ContractAgency',
						'jointype'			=> 	'LEFT' 
					),	
					array('table' 			=> 	'companies',
						'condition' 		=> 	'companies.Id = contracts.CompanyId',
						'jointype'			=> 	'LEFT' 
					),	
				);	
				$selectContract				=	'contracts.Id,AgentName,CompanyName,CompanyId,ContractAgency';
				$WhereContract				=	array('contracts.ContractorId' => $data['CONTRACTORID'],'contracts.Id' => $data['CONTRACTID'], 'contracts.RecordStatus' => 1, 'agencies.RecordStatus' => 1, 'companies.RecordStatus' => 1);
				$contracts					= 	$this->DatabaseModel->WRSFetchAllByJoin('contracts',$selectContract,$joinContract,$WhereContract)->row();
				$data['AGENTID']			=	$contracts->ContractAgency;
				$data['COMPANYID']			=	$contracts->CompanyId;
				$data['AGENCYNAME']			=	$contracts->AgentName;
				$data['COMAPNYNAME']		=	$contracts->CompanyName;
		$data['CONTRACTID']     = $contracts->Id;
			}
		}   
		return $data;
	}

 /* Its not actual data base delete its for make record status false*/
	function Delete($table,$where,$updateData=''){
		if($updateData == ''){
			$updateData = array('RecordStatus'		=>	0,
	  							'LastModifiedDate'  => date('Y-m-d H:i:s'),
	  							'LastModifiedBy'  =>  $this->session->userId
	  							);
		}
		
	 // var_dump($updateData);exit;
	$this->DatabaseModel->AuditTrialUpdate($table, 'Id', $updateData, $where);
		return $update 		= 	$this->db->update($table, $updateData,$where);
	}
  
  /*Data table functions*/
  
  function GetDataTable($table = '', $select = '*', $where =false, $limit = '', $offset = 0, $orderBy = '', $search = false) {

		$this->db->select($select);
		  if($table != 'users'){
			$this->db->where('RecordStatus', 1); // Default for all table
		}
	  
	   
		if (!empty($where)){
			$this->db->where($where);
		}
		if (!empty($orderBy) ) {
			$this->db->order_by($orderBy);
		}
		if (!empty($search)) {
			$this->db->group_start();
				$this->db->or_like($search);
			$this->db->group_end();

        }
        if ($limit != '') {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get($table);
    }
    
    
	
	function GetDataTableJoin($table = '', $select = '*', $where =false, $joins = '', $limit = '', $offset = 0, $orderBy = '', $search = false,$groupBy = '',$recordStatus=1,$distinct = 0,$wherein = '',$wherenotin = '',$type = '') {


	$this->db->select($select);

	if($distinct == 1){
	  $this->db->distinct();
	}

	if($recordStatus){
	  $this->db->where("{$table}.RecordStatus", 1); // Default for all table
	}
	if (!empty($where)){
	  $this->db->where($where);
	}
	if (is_array($wherein) && count($wherein) > 0){
	  $this->db->where_in($wherein['key'],$wherein['values']);
	}
	if (is_array($wherenotin) && count($wherenotin) > 0){
	  $this->db->where_not_in($wherenotin['key'],$wherenotin['values']);
	}
	if (is_array($joins) && count($joins) > 0){
	  $this->join($joins);
	}
	if (!empty($orderBy) ) {
	  $this->db->order_by($orderBy);
	}
	if (!empty($search)) {
	  $this->db->group_start();
	  $this->db->or_like($search);
	  $this->db->group_end();
	}

	if($groupBy != '') {
	  $this->db->group_by($groupBy);
	}


    if ($limit != '') {
      $this->db->limit($limit, $offset);
    }
    if($type != 'GET_QUERY'){
      return $this->db->get($table);
    }else{
      $this->db->from($table);
      $query = $this->db->get_compiled_select();
      return $query;
    }    

  }

  function GetDataTableJoinOrWhere($table = '', $select = '*', $where =false, $orWhere =false, $joins = '', $limit = '', $offset = 0, $orderBy = '', $search = false,$groupBy = '',$recordStatus=1,$distinct = 0,$wherein = '',$wherenotin = '') {

	$this->db->select($select);

	if($distinct == 1){
	  $this->db->distinct();
	}

	if($recordStatus){
	  $this->db->where("{$table}.RecordStatus", 1); // Default for all table
	}
	if (!empty($where)){
	  $this->db->where($where);
	}
	if (!empty($orWhere)){
	  $this->db->group_start();
	  $this->db->or_where($orWhere);
	  $this->db->group_end();
	}
	if (is_array($wherein) && count($wherein) > 0){
	  $this->db->where_in($wherein['key'],$wherein['values']);
	}
	if (is_array($wherenotin) && count($wherenotin) > 0){
	  $this->db->where_not_in($wherenotin['key'],$wherenotin['values']);
	}
	if (is_array($joins) && count($joins) > 0){
	  $this->join($joins);
	}
	if (!empty($orderBy) ) {
	  $this->db->order_by($orderBy);
	}
	if (!empty($search)) {
	  $this->db->group_start();
	  $this->db->or_like($search);
	  $this->db->group_end();
	}

	if($groupBy != '') {
	  $this->db->group_by($groupBy);
	}

	if ($limit != '') {
	  $this->db->limit($limit, $offset);
	}
	return $this->db->get($table);
  }
  
	public function GetTotalRows($table,$Where=null,$search=null) {
		$this->db->select("COUNT(*) as num");
		if($table != 'users'){
			$this->db->where('RecordStatus', 1); // Default for all table
		}
		if(!empty($Where)){
			 $this->db->where($Where);
		}
		if (!empty($search)) {
			$this->db->group_start();
				$this->db->or_like($search);
			$this->db->group_end();
		}
		$query = $this->db->get($table);
		$result = $query->row();
		if (isset($result))
			return $result->num;
		return 0;
	}
	public function GetTotalRowsJoin($table,$Where='',$joins='',$search=null,$groupBy='') {
		$this->db->select("COUNT(*) as num");
		$this->db->where($table.'.RecordStatus', 1); // Default for all table
		if($Where != ''){
		   $this->db->where($Where);
		}
		if (!empty($search)) {
		  $this->db->group_start();
		$this->db->or_like($search);
	  $this->db->group_end();
		}
		 if (is_array($joins) && count($joins) > 0){
	   $this->join($joins);
	 }

	 if($groupBy != '') {
			$this->db->group_by($groupBy);
		}
		$query = $this->db->get($table);
		$result = $query->row();
		if (isset($result))
			return $result->num;
		return 0;
	}
	
	public function GetNumOfRows($table,$Where='',$joins='',$search=null,$groupBy='',$recordStatus = 1,$distinct = 0,$wherein = '',$wherenotin = '',$select='') {
	
	 if($select != ''){
	   $this->db->select($select);
	 }else{
	   $this->db->select("*");
	 }

	if($distinct == 1){
	  $this->db->distinct();
	}
	if($recordStatus){
	  $this->db->where($table.'.RecordStatus', 1); // Default for all table
	}
	if($Where != ''){
	  $this->db->where($Where);
	}
	if (is_array($wherein) && count($wherein) > 0){
	  $this->db->where_in($wherein['key'],$wherein['values']);
	}
	if (is_array($wherenotin) && count($wherenotin) > 0){
	  $this->db->where_not_in($wherenotin['key'],$wherenotin['values']);
	}
	
	if (!empty($search)) {
	  $this->db->group_start();
	  $this->db->or_like($search);
	  $this->db->group_end();
	}
	if (is_array($joins) && count($joins) > 0){
	  $this->join($joins);
	}

	if($groupBy != '') {
	  $this->db->group_by($groupBy);
	}
	$query = $this->db->get($table);
	return $query->num_rows();
  }

  public function GetNumOfRowsOrWhere($table,$Where='',$orWhere='',$joins='',$search=null,$groupBy='',$recordStatus = 1,$distinct = 0,$wherein = '',$wherenotin = '') {
	
	$this->db->select("*");

	if($distinct == 1){
	  $this->db->distinct();
	}
	if($recordStatus){
	  $this->db->where($table.'.RecordStatus', 1); // Default for all table
	}
	if($Where != ''){
	  $this->db->where($Where);
	}
	if (!empty($orWhere)){
	  $this->db->group_start();
	  $this->db->or_where($orWhere);
	  $this->db->group_end();
	}
	if (is_array($wherein) && count($wherein) > 0){
	  $this->db->where_in($wherein['key'],$wherein['values']);
	}
	if (is_array($wherenotin) && count($wherenotin) > 0){
	  $this->db->where_not_in($wherenotin['key'],$wherenotin['values']);
	}
	
	if (!empty($search)) {
	  $this->db->group_start();
	  $this->db->or_like($search);
	  $this->db->group_end();
	}
	if (is_array($joins) && count($joins) > 0){
	  $this->join($joins);
	}

	if($groupBy != '') {
	  $this->db->group_by($groupBy);
	}
	$query = $this->db->get($table);
	return $query->num_rows();
  }
  
  /* SUPPORTING FUNCTIONS */
  
  /* Join Rekated functions */
	function join($joins){
		foreach($joins as $k => $v){	
			$this->db->join($v['table'], $v['condition'], $v['jointype']);
		}
	}

	function CheckContractorId($redirect='contractor/personalinfo'){

	$CONTRACTORID   =   $this->input->post('CONTRACTORID');
	if($CONTRACTORID == ''){
	  redirect($redirect); 
	}
  }
  function CheckContractId($redirect='contract/summary'){

		$CONTRACTID 	= 	$this->input->post('CONTRACTID');
		if($CONTRACTID == ''){
			redirect($redirect); 
		}
	}
  
  function checkEmailAccessGranted()
  {
	  $UserEmail = $this->session->userEmail;
	  $domain = strstr($UserEmail, '@');
	  if($domain == '@fenero.ie')
		return 'granted';
	  else
		return 'denied';    
  }

	function dateForSearch($searcharray,$search,$fileld = 'InvoiceDate'){
		
		$isDate             =   explode('-', $search);
		$countDate          =   count($isDate);

		if($countDate == 2){
			if(strlen($isDate[1]) < 2){
				$searcharray[$fileld]     =   "-".$isDate[0];
			}else{
				$searcharray[$fileld]     =   $isDate[1]."-".$isDate[0];
			}
		}
		if($countDate == 3){
			if($isDate[2] == '' || strlen($isDate[2]) < 4){
				$searcharray[$fileld]     =   $isDate[1]."-".$isDate[0];
			}else{
				$searcharray[$fileld]     =   date('Y-m-d',strtotime($search));
			}
		}
		return $searcharray;
	}

/**************** EMAIL Sending function : Handles both `Gmail API` and `SMTP`  ********************/
   
 function SendEmail($toAddress,$ccAddress = '',$bccAddress = '',$subject,$body,$attachment = '',$mailQueue = 0,$type = '',$typeId = '',$replyTo = '',$fromEmail = ''){

   /**
   *
   * Email sending common function for all email screen in Mentis. 
   * This can handle the Emailing with Gmail API,SMTP and Mail Queue system
   *
   * Parameter::
   ***************
   * $toAddress - Array,  
   * $ccAddress - Array, 
   * $bccAddress - Array, 
   * $subject - String, 
   * $body - String, 
   * $attachment - Multi Array
   * $mailQueue - 1/0 - to determine if it need to use email queue system 
   ***************     
   *  return array('success' => '','message' => '');
   *
  */

  //Constants
  $SMTP   = unserialize(SMTP);
  $MAIL   = unserialize(MAIL);
  $EMAIL  = unserialize(EMAIL);

  if(is_array($toAddress) && count($toAddress) > 0){
	//do nothing
  }else{
	return array('success' => 0,'message' => 'Invalid To Email address');
  }

  if($mailQueue == 1){


    //*********** Email Queue ************//
    $this->load->library('Mailqueuelib');
    unset($emailQueue);
    $emailQueue = new Mailqueuelib();
    if($fromEmail != ''){
    	$emailQueue->set_from($fromEmail);
    }
    $emailQueue->set_to($toAddress);
    $emailQueue->set_cc($ccAddress);
    $emailQueue->set_bcc($bccAddress);
    $emailQueue->set_subject($subject);
    $emailQueue->set_message($body);
    $emailQueue->set_type_id($type,$typeId);
    $emailQueue->set_reply_To($replyTo);
    //Attachments
    if(is_array($attachment) && count($attachment) > 0){          

      $filePathArr = array_column($attachment, 'FilePath');
      $emailQueue->set_attach($filePathArr);
    }

    $result = $emailQueue->prepareQueue();
    if($result){
      return array('success' => 1,'message' => 'Mail successfully sent');
    }else{
      return array('success' => 0,'message' => 'Mail failed to send');  
    }

  }else{

	  $allowedEmail  = $this->checkEmailAccessGranted();    //checking the logged user's email address is from '@fenero.ie'  
	  if($this->session->IsFeneroId && $allowedEmail == "granted" && isset($this->session->accessToken)){ 
		  //Email using GMAIL API
		  $this->load->library('googleauth');
		  $accessToken = $this->session->accessToken; 
		  if(isset($accessToken) && $accessToken){

			$this->googleauth->client->setAccessToken($accessToken); 

		  }else{
		   
		  return array('success' => 0,'message' => 'No Gmail Access Token exist');
		  } 

		  $objGMail       = new Google_Service_Gmail($this->googleauth->client);
		  $strRawMessage  = "";
		  $boundary       = uniqid(rand(), true);
		  $subjectCharset = $charset = 'utf-8';

		  $EmailSubject   = $subject;
		  $EmailBody      = $body; 
		  $EmailBody      = str_replace("=","=3D",$EmailBody);  
		  $fromEmail      = $this->session->userEmail;    //From Email
		  $fromName       = $this->session->displayName;  //From Name  
		  $toEmailsName   = $ccEmailsName = $BccEmailsName = '';

		  if(ENVIRONMENT == 'development'){    
			
			 $strRawMessage .= 'To: ' .$toEmailsName . " <rajeesh@fenero.in>" . "\r\n";  
			 $strRawMessage .= 'Cc: ' .$ccEmailsName . " <premjith.kk@fenero.in>" . "\r\n";   

		  }else if(ENVIRONMENT == 'production'){

		   //To Address
		  if(is_array($toAddress) && count($toAddress) > 0){

			 foreach($toAddress as $ToEmail){
			 $strRawMessage .= 'To: ' .$toEmailsName . " <" . $ToEmail . ">" . "\r\n";   
			 } 
		  }else{

			return array('success' => 0,'message' => 'Invalid To Email address');
		  }

		  //Cc Address
		  if(is_array($ccAddress) && count($ccAddress) > 0){

			foreach($ccAddress as $CcEmail){                                                                         
			  $strRawMessage .= 'Cc: ' .$ccEmailsName . " <" . $CcEmail . ">" . "\r\n";
			}
		  }

		  //Bcc Address 
		  if(is_array($bccAddress) && count($bccAddress) > 0){

			foreach($bccAddress as $BccEmail){                                                                         
			  $strRawMessage .= 'Bcc: ' .$BccEmailsName . " <" . $BccEmail . ">" . "\r\n";
			}
		  }          
		  }

		  $strRawMessage .= 'From: '.$fromName . " <" . $fromEmail . ">" . "\r\n";  
		  $strRawMessage .= 'Reply-To: '.$fromName . " <" . $fromEmail . ">" . "\r\n";            
		  $strRawMessage .= 'Subject: =?' . $subjectCharset . '?B?' . base64_encode($EmailSubject) . "?=\r\n";
		  $strRawMessage .= 'MIME-Version: 1.0' . "\r\n"; 

		  //Attachments        
		  if(is_array($attachment) && count($attachment) > 0){

			$finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension 
			foreach($attachment as $file){

			$filePath = $file['FilePath'];
			$fileName = $file['FileName'];
			$mimeType = finfo_file($finfo, $filePath); 
			$fileData = chunk_split(base64_encode(file_get_contents($filePath)), 76, "\n") . "\r\n";

			$strRawMessage .= 'Content-type: Multipart/Mixed; boundary="' . $boundary . '"' . "\r\n";
			$strRawMessage .= "\r\n--{$boundary}\r\n";
			$strRawMessage .= 'Content-Type: '. $mimeType .'; name="'. $fileName .'";' . "\r\n";
			// $strRawMessage .= 'Content-ID: <' . $fromEmail . '>' . "\r\n";  
			$strRawMessage .= 'Content-Description: ' . $fileName . ';' . "\r\n";
			$strRawMessage .= 'Content-Disposition: attachment; filename="' . $fileName . '"; size=' . filesize($filePath). ';' . "\r\n";
			$strRawMessage .= 'Content-Transfer-Encoding: base64' . "\r\n\r\n";   
			$strRawMessage .=  $fileData;               
			$strRawMessage .= "--{$boundary}\r\n"; 
			}   
		  }
		 
		  $strRawMessage .= 'Content-Type: text/html; charset=' . $charset . "\r\n";
		  $strRawMessage .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
		  $strRawMessage .= $EmailBody . "\r\n"; 

		  try {
			// The message needs to be encoded in Base64URL
			$mime = rtrim(strtr(base64_encode($strRawMessage), '+/', '-_'), '=');
			$msg  = new Google_Service_Gmail_Message();
			$msg->setRaw($mime);
			$objSentMsg = $objGMail->users_messages->send("me", $msg);

			if($objSentMsg->getId()){

			  return array('success' => 1,'message' => 'Mail successfully sent');
			}else{

			  return array('success' => 0,'message' => 'Mail failed to send');
			}
		  }catch (Exception $e) {

			return array('success' => 0,'message' => 'Mail failed to send');                  
		  }     

	  }else{

		//Email using SMTP
		$this->load->library('email');   
		//Mail configuration
		$config = array(
		  'protocol' => 'smtp',
		  'smtp_host' => $SMTP['host'],
		  'smtp_port' => $SMTP['port'],
		  'smtp_user' => $SMTP['username'],
		  'smtp_pass' => $SMTP['password'],
		  'charset' => $SMTP['charset'],
		  'mailtype' => 'html',
		  'smtp_timeout'=> 50
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n"); 

		$this->email->clear(TRUE); //Clear all the email variables

		if(ENVIRONMENT == 'development'){  

		   $this->email->to('rajeesh@fenero.in');                    
															   

		}else if(ENVIRONMENT == 'production'){

		  $this->email->to($toAddress);
		  $this->email->cc($ccAddress);
		  $this->email->bcc($bccAddress);

		}      

		$this->email->reply_to($MAIL['fromemail'], $MAIL['fromname']);
		$this->email->from($MAIL['fromemail'],$MAIL['fromname']);
		$this->email->subject($subject); 
		$this->email->message($body);           

		//Attachments
		if(is_array($attachment) && count($attachment) > 0){

		  foreach($attachment as $file){
		  
		  $filePath = $file['FilePath'];
		  $fileName = $file['FileName'];
		  $this->email->attach($filePath);
		  }  
		}
		if (!$this->email->send()){
		  // Generate error
		  return array('success' => 0,'message' => 'Mail failed to send');
		}else{

		  return array('success' => 1,'message' => 'Mail successfully sent');
		}
	  }//SMTP Block
  }//else mailQueue
  } //Function Block


  //Payslip send function
  function SendPayslipEmail($toAddress,$ccAddress = '',$bccAddress = '',$subject,$body,$attachment = '',$type=''){

				//Constants
				if($type == 'FLC'){ // MEN-646 - FLC Onward Payment By nithin on 10-02-2021
					$SMTP   = unserialize(FLC_SMTP);
				}else{
					$SMTP   = unserialize(SMTP);
				}			
				$MAIL   = unserialize(MAIL);
				$EMAIL  = unserialize(EMAIL);
				
				$this->load->library('email');   
				//Mail configuration
				$config = array(
					'protocol' => 'smtp',
					'smtp_host' => $SMTP['host'],
					'smtp_port' => $SMTP['port'],
					'smtp_user' => $SMTP['username'],//PAYROLL_EMAIL_USER,
					'smtp_pass' => $SMTP['password'],//PAYROLL_EMAIL_USER_PASSWD,
					'charset' => $SMTP['charset'],
					'mailtype' => 'html'
				);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n"); 

				$this->email->clear(TRUE); //Clear all the email variables

				if(ENVIRONMENT == 'development'){  

					$this->email->to($this->session->userEmail);
					$this->email->bcc($EMAIL['tester3']);		            
					

				}else if(ENVIRONMENT == 'localdevelopment'){  

					$this->email->to($this->session->userEmail);
					$this->email->bcc($EMAIL['tester1']);		            
					


				}else if(ENVIRONMENT == 'production'){

				  $this->email->to($toAddress);
				  $this->email->cc($ccAddress);
				  $this->email->bcc($bccAddress);

				}      
				if($type == 'FLC'){
					$this->email->reply_to('flcsupport@fenero.ie', $MAIL['fromname']);
					$this->email->from('flcsupport@fenero.ie',$MAIL['fromname']); //PAYROLL_EMAIL_USER
				}else{
					$this->email->reply_to($MAIL['fromemail'], $MAIL['fromname']);
					$this->email->from($MAIL['fromemail'],$MAIL['fromname']); //PAYROLL_EMAIL_USER
				}
				$this->email->subject($subject); 
				$this->email->message($body);           

				//Attachments
				if(is_array($attachment) && count($attachment) > 0){

				  foreach($attachment as $file){
					
					$filePath = $file['FilePath'];
					$fileName = $file['FileName'];
					$this->email->attach($filePath);
				  }  
				}
				
				if (!$this->email->send()){
					// Generate error
					return array('success' => 0,'message' => 'Mail failed to send');
				}else{

					return array('success' => 1,'message' => 'Mail successfully sent');
				}

	}  

   //Solution Signature Block
  function SolutionTeamSignature() {

	  $signatureBody = '<table style="border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td valign="top" style="width:100px">
								<span>
								   <img src="'.base_url().'/public/img/umbrellasupportlogo.png" width="70px;">
								</span>
							</td>
						   <td>
							 
							  <b><span style="color:green">FENERO SOLUTIONS TEAM</span></b><br><br>
							  <div style="line-height:15px;"> 
								<b><span style="color:gray;"><font size="1">Fenero, 50A Rosemount Park Drive, Rosemount Business Park,</font></span></b><br>
								<b><span style="color:gray;"><font size="1">Ballycoolin, Dublin 11</font></span></b>
							  </div>
							  <br>
							  <div style="line-height:15px;"> 
								<b><span style="color:green"><font size="1">T</font></span></b>
								<b><span style="color:gray;"><font size="1">+353 (0)1 6877400</font></span></b>
								<span style="color:green">|</span><b>
								<b><span style="color:green"><font size="1">F</font></span></b>
								<b><span style="color:gray;"><font size="1">+353 (0)1 6865582</font></span></b><br>
								<b><span style="color:green"><font size="1">E</font></span></b>
								<a href="mailto:hello@fenero.ie"><font size="1"><span style="color:gray;">hello@fenero.ie</span></font></a>
								<span style="color:green">|</span>
								<b><span style="color:green"><font size="1">W</font></span></b>&nbsp;<a href="www.fenero.ie"><font size="1"><span style="color:gray;">www.fenero.ie</span></font></a>
							  </div>
							  <br>
								<span>
								   <a href="https://www.facebook.com/FeneroDublin" target="_blank"><img src="'.base_url().'/public/img/facebook.png" width="20px;"></a>&nbsp;
								   <a href="https://www.linkedin.com/company/fenero-tax-&-accounting-contractor-solutions" target="_blank"><img src="'.base_url().'/public/img/instagram.png" width="20px;"></a>&nbsp;
								   <a href="https://twitter.com/Fenero" target="_blank"><img src="'.base_url().'/public/img/twitter.png" width="20px;"></a>&nbsp;
								   <a href="https://www.instagram.com/FeneroPersonalTax" target="_blank"><img src="'.base_url().'/public/img/camera.png" width="20px;"></a>
							  </span>
						  </td>  
					  </tr>
					  </table>

					  <table>
						  <tr><td>&nbsp;</td></tr>
						  <tr>
							  <td><b><span style="color:green">OUR CHARITY PARTNER</span></b><br>
								  <div style="line-height:10px;">
									  <span style="color:gray;">
										  <font size="1" name="Arial">
											  Soar, is seeking &euro;3 million in donation pledges to help them reach more young Irish people with their early intervention wellness workshops. If you can help, please go to <a href="http://soar.ie/contribute">http://soar.ie/contribute</a>&nbsp;or contact the team at <a href="info@soar.ie">info@soar.ie</a>
										  </font>
									  </span>
								  </div>
							  </td>
						  </tr>
						  <tr height = 10px></tr>
						  <tr>
							  <td><b><span style="color:green">IMPORTANT DISCLAIMER &amp; INFORMATION</span></b><br>
								  <div style="line-height:10px;"> 
									  <span style="color:gray;">
										  <font size="1" family="Arial">This e-mail may contain confidential and/or privileged information. If you are not the intended recipient, or person responsible for delivering it to the intended recipient,
										  please notify the sender immediately and destroy this e-mail. Any unauthorized copying,
										  disclosure or distribution of the material in this e-mail is strictly forbidden. 
										  The opinions/views/comments on this e-mail are those of the senders and do not necessarily
										  reflect any views or policies of Fenero.No liability is accepted by Fenero for any losses 
										  caused by viruses contracted during transit over the Internet or present in any receiving system. 
										  This e-mail is not intended to create legally binding commitments on behalf of Fenero. 
										  If you have any queries regarding this email then please send your queries to 
										  <a href="hello@fenero.ie">hello@fenero.ie</a>
										  </font>
									  </span>
								  </div>
							  </td>
						  </tr>  
						  <tr height = 10px></tr>
						   <tr>
							  <td><b><span style="color:green">VIRUS WARNING</span></b><br>
								  <div style="line-height:10px;"> 
									  <span style="color:gray;">
										 <font size="1">
											You are requested to carry out your own virus check before opening any attachment. Fenero accepts no liability for any loss or damage which may be caused by software viruses.
										  </font>
									  </span>
								  </div>
							  </td>
						  </tr>
				  </table>';

	  return $signatureBody;
   }//solution signature block
   

/***************************************************************************************************/   

  function generateFileName($sectionId='',$userId,$filename){
	  $filename     = $this->makeClean($filename);
	  $mt       =   str_replace('.','_',str_replace(' ','_',microtime()));
	  if($sectionId   == ''){
		$sectionId  = mt_rand(100,10000000);
	  }
	  return $sectionId.'_'.$userId.'_'.$mt.'_fN_'.$filename;
	}


  function makeClean($text){

	$ext            =   pathinfo($text)['extension'];
	$text           =   pathinfo($text)['filename'];
	$result_with_dashes   =   true; //set this to false if you want output with spaces as a separator
	$input_is_english_only  =   true; //set this to false if your input contains non english words
	$text           =   str_replace(array('"','+',"'"), array('',' ',''), urldecode($text));

	if($input_is_english_only === true){  
	  $text         =   preg_replace('/[~`\!\@\#\$\%\^\&\*\(\)\=\+\/\?\>\<\,\[\]\:\;\|\\\]/',"",$text);
	}else{
	  $text         =   preg_replace('/[^A-Za-z0-9\s\s+\.\)\(\{\}\-]/', "", $text);
	}

	$bad_brackets       =   array("(", ")", "{", "}");
	$text           =   str_replace($bad_brackets, "", $text);
	$text           =   preg_replace('/\s+/', '_', $text);
	$text           =   trim($text,' .-');
	$text           =   str_replace('.','',$text);
	if($result_with_dashes === true){
	  $text         =   str_replace(' ','_',$text);
	}
	$text           =   preg_replace('/-+/', '', $text);
	$text           =   strtolower($text);
	$text           =   $text.'.'.$ext;
	return $text;

  }

  function uploadFile($file, $fId, $path, $allowed, $fName = ''){

		if(!empty($_FILES[$fId]['name'])) {
			//file types allowed
			$filename   =   $_FILES[$fId]['name'];
			$ext        =   pathinfo($filename,PATHINFO_EXTENSION);
			if(!in_array($ext,$allowed) ) {
				//die('Invalid file');
				return false;
			}else {
				$fileArr                    =   explode(".", $filename);

				if($fName){
				  $uploadFileName           =   $fName;
				}else{
				  $uploadFileName           =   $fileArr[0];  
				}
				
				$config['upload_path']      =   $path;
				$config['overwrite']        =   true;
				$config['file_name']        =   $uploadFileName;
				$config['allowed_types']    =   $allowed;
				$this->load->library('upload',  $config);
				$this->upload->initialize($config);
				if ($this->upload->do_upload($fId)) {
					$fileData               =   $this->upload->data();
					$uploadedFileName       =   $fileData['file_name'];
					return $uploadedFileName;
				} else {
					return false;
				} 
			}
		}else{
			return false;
		}

   }

  function insertToTable($table,$insertData){

	  $insert = $this->db->insert($table,$insertData);
	  if($insert){
		return $this->db->insert_id();
	  }else{
		return false;
	  }

  } 

function insertToTableBatch($table,$insertData){

	$insert     =   $this->db->insert_batch($table,$insertData);
	
	if($insert){
		return true;
	}else{
		return false;
	}

}  

 function updateTable($table,$data,$where){

	$this->db->where($where);
	$this->db->update($table, $data);

 } 

  function deleteTable($table,$where){

	$this->db->where($where);
	return $this->db->delete($table);

  }

  function deleteTableBulk($table,$where,$data){

	$this->db->where_in($where,$data);
	$this->db->delete($table);

  }

  function getExcelCellDateFormat($dateInDaysFormat){

	$excel_date = $dateInDaysFormat; 
	$unix_date = ($excel_date - 25569) * 86400;
	$excel_date = 25569 + ($unix_date / 86400);
	$unix_date = ($excel_date - 25569) * 86400;
	return gmdate("Y-m-d", $unix_date);
  }

  function weekRange($date) {
	$ts    = strtotime($date);
	$start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
	return array(date('Y-m-d', $start),
				 date('Y-m-d', strtotime('next saturday', $start))
			   );
}

	//return the count of weekend and holidays within the date range and holidays given
	function getWeekendHolidayCount($FromDate,$ToDate,$holidays){

		$ToDate     =   date('Y-m-d',strtotime($ToDate.'+1 day'));
		$no         =   0;
		$start      =   new DateTime($FromDate);
		$end        =   new DateTime($ToDate);
		$interval   =   DateInterval::createFromDateString('1 day');
		$period     =   new DatePeriod($start, $interval, $end);
		foreach ($period as $dt){
			if ($dt->format('N') == 7 || $dt->format('N') == 6){
				$no++;
			}
			if(in_array($dt->format('Y-m-d'), $holidays)){
				$no++;
			}
		}
		return $no;

	}

	function createTempTable($tempTable,$table,$select,$where,$join = '',$orderby = ''){
	  	//Creating Temporary tables 
	  	$tempPayrollDrop      =   "DROP TEMPORARY TABLE IF EXISTS $tempTable";
	  	$this->db->query($tempPayrollDrop);
	  	if($join != ''){
	  		$tempPayrollsInsert   =   "CREATE TEMPORARY TABLE IF NOT EXISTS $tempTable (SELECT $select FROM $table $join WHERE $where $orderby)"; 
	  	}else{
	  		$tempPayrollsInsert   =   "CREATE TEMPORARY TABLE IF NOT EXISTS $tempTable (SELECT $select FROM $table WHERE $where $orderby)"; 	
	  	}
	  	
	  	$this->db->query($tempPayrollsInsert);
	  	return true;
	}

	function correctToDecimalPoint($number,$decimalPoint = 2,$withOutComma = true){
		if($withOutComma){
			return number_format($number,$decimalPoint, '.', '');
		}else{
			return number_format($number,$decimalPoint);
		}
	}
  

    function dateDifference($date1='',$date2=''){

      if($date1=='' || $date2 == ''){
      return 0;
      }
      //echo $date1."<br/>";
      //echo $date2."<br/>";

      $date1  = date_create($date1);
    $date2  = date_create($date2);
    $diff   = date_diff($date1,$date2);
    return $diff->format("%a");
  }



    /*
      MEN-722     -   Refer-a-Friend Utility
      Developer     -   PREMJITH
      Modiied Date  -   26-05-2021
      Begin
  */
    function checkFirstPay($contractorId='',$contractId=''){
      if($contractorId == ''){
        return 'Contractor Id Missing';
      }
      $this->db->select("Id");
      $this->db->where('RecordStatus', 1); 
      $this->db->where('ContractorId', $contractorId); 
      if($contractId != ''){
        $this->db->where('ContractId', $contractId); 
      }
      $query = $this->db->get('payrolls');
      return $query->num_rows();

    }


    /*
      MEN-722     -   Refer-a-Friend Utility
      Developer     -   PREMJITH
      Modiied Date  -   26-05-2021
      End
  */
  


  public function Exceldateformat($dispValue='',$column=''){
      
      $excludedFields = unserialize(DATE_PARSING_EXCLUDED_FIELDS);
       
      if(in_array($column, $excludedFields)){

      	$newValue = $dispValue;//don't process the date formatting if the field is in the excluded list

      }else if($dispValue == "0000-00-00" || $dispValue == "1970-01-01" || $dispValue == "" ){ 

          $newValue  = "";

      }else{

          $len = strlen($dispValue);
          if($len >= 11){//if datetime

            $newValue  =  date("d/m/Y", strtotime($dispValue))." ".date("h:i:s A",strtotime($dispValue));
            // print_r($newValue);
            // die();
          }else{

              $newValue  =  date("d/m/Y", strtotime($dispValue));
          } 

      }             
          
             
      return $newValue; 
  }

}

