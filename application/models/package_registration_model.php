<?php
class package_registration_model extends CI_Model {
	private $data = array();
	private $SQL ="";
	function getRegistrationByUserId($a=array()){
		$res = false;$whereArray = array();
		$this->filterData_active($a);
		$this->db->from('package_registration as `packreg`');
		if(!empty($a['user_id'])){
			$whereArray['packreg.user_id'] = $a['user_id'];
		}
		if(!empty($a['status'])){
			$whereArray['packreg.status'] = $a['status'];
		}
		$whereArray['packreg.start_date <='] = date('Y-m-d');
		$whereArray['packreg.end_date >='] = date('Y-m-d');
		

		$this->db->where($whereArray);
		
		$query = $this->db->get();
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		return $res;
	}
	function __toString(){
		return (string)end($this->db->queries);
	}
}
?>