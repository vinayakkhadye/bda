<?php
class doctor_details_model extends CI_Model {
	private $data = array();
	private $SQL ="";
	function getServices($a=array()){
		$this->filterData_active($a);
		$this->db->select('id,name');

		$this->db->from('services as `sv`');
		$whereArray['sv.status'] = 1;
		
		$this->db->where($whereArray);
		$query = $this->db->get();
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		return $res;
	}	

	function getQualification($a=array()){
		$this->db->from('qualification as `qu`');
		$whereArray['qu.status'] = 1;
		
		$this->db->where($whereArray);
		$query = $this->db->get();
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		return $res;
	}	
	function getCollege($a=array()){
		$this->filterData_active($a);
		$this->db->select('id,name');
		$this->db->from('college as `c`');
		$whereArray['c.status'] = 1;
		
		$this->db->where($whereArray);
		$query = $this->db->get();
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		return $res;
	}	
	function getMembership($a=array()){
		$this->filterData_active($a);

		$this->db->select('id,name');
		$this->db->from('memberships as `mem`');
		$whereArray['mem.status'] = 1;
		
		$this->db->where($whereArray);
		$query = $this->db->get();
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		return $res;

	}
	function getCouncil($a=array()){
		$this->db->select('id,name');
		$this->db->from('council as `con`');
		$whereArray['con.status'] = 1;
		
		$this->db->where($whereArray);
		$query = $this->db->get();
		if($query->num_rows>0){
			foreach ($query->result_array() as $row){
				$res[] =  $row;
			}
		}
		return $res;

	}
	function getPatientNumbers($a=array()){
		$res = false;
		$this->filterData_active($a);

		$this->db->from('doctor_patient_review_detail as `prd`');
		$whereArray['prd.status'] = 1;
		$whereArray['prd.doctor_id'] = $a['doctor_id'];
		
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
		return (string)$this->db->last_query();
	}
}
?>