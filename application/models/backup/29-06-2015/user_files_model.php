<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class user_files_model extends CI_Model
{	
	public function __construct()
	{
		parent::__construct();
	}

	function insert_user_files($data)
	{
		$this->db->insert('user_files', $data);
		return $this->db->insert_id();
	}
	function delete_user_files($data)
	{
		$this->db->delete('user_files', $data);
		return $this->db->affected_rows();
	}
	function update_user_files($id,$data)
	{
		if($id)
		{
			$this->db->where('id', $id);
			$this->db->update('user_files', $data); 		
			return $this->db->affected_rows();
		}
		return false;
	}
	function insert_user_shared_files($data)
	{
		$this->db->insert('user_shared_files', $data);
		return $this->db->insert_id();
	}

	function delete_user_shared_files($data)
	{
		$this->db->delete('user_shared_files', $data);
		return $this->db->affected_rows();
	}

	function check_user_shared_files($a=array())
	{
		$this->db->select("uf.`id` AS 'file_id',uf.`file_path`");
		$this->db->from("user_files uf");
		$this->db->join('user_shared_files usf', 'uf.id=usf.`file_id`');
		if(isset($a['file_id']) && !empty($a['file_id']))
		{
			$whereArray['uf.id'] = $a['file_id'];
		}
		if(isset($a['patient_id']) && !empty($a['patient_id']))
		{
			$whereArray['usf.`patient_id`'] = $a['patient_id'];
		}
		if(isset($a['doctor_id']) && !empty($a['doctor_id']))
		{
			$whereArray['usf.`doctor_id`'] = $a['doctor_id'];
		}
		if(isset($a['owner_id']) && !empty($a['owner_id']))
		{
			$whereArray['usf.`owner_id`'] = $a['owner_id'];
		}
		if(isset($whereArray) && is_array($whereArray) && sizeof($whereArray)>0)
		{
			$this->db->where($whereArray);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
		}
		return false;

	}
	
	function get_file_details($a=array())
	{

		$this->db->select("uf.`id` AS 'file_id',uf.title, uf.report_type,uf.report_date,
		 uf.`file_name`,uf.`file_thumbnail`,uf.`file_type`,uf.`notes`,usf.`patient_id`,usf.`doctor_id`,usf.`owner_id`");
		$this->db->from("user_files uf");
		$this->db->join('user_shared_files usf', 'uf.id=usf.`file_id`');
		
		if(isset($a['file_id']) && !empty($a['file_id']))
		{
			$whereArray['uf.id'] = $a['file_id'];
		}
		if(isset($a['patient_id']) && !empty($a['patient_id']))
		{
			$whereArray['usf.`patient_id`'] = $a['patient_id'];
		}
		if(isset($a['doctor_id']) && !empty($a['doctor_id']))
		{
			$whereArray['usf.`doctor_id`'] = $a['doctor_id'];
		}
		if(isset($a['owner_id']) && !empty($a['owner_id']))
		{
			$whereArray['usf.`owner_id`'] = $a['owner_id'];
		}
		
		if(isset($whereArray) && is_array($whereArray) && sizeof($whereArray)>0)
		{
			$this->db->where($whereArray);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->result_array();
			}
		}
		return false;
	}
	function get_download_file($a=array())
	{


		$this->db->from("user_files uf");
		
		if(isset($a['id']) && !empty($a['id']))
		{
			$whereArray['uf.id'] = $a['id'];
		}
		if(isset($a['patient_id']) && !empty($a['patient_id']))
		{
			$whereArray['uf.`patient_id`'] = $a['patient_id'];
		}
		if(isset($a['doctor_id']) && !empty($a['doctor_id']))
		{
			$whereArray['uf.`doctor_id`'] = $a['doctor_id'];
		}
		
		if(isset($whereArray) && is_array($whereArray) && sizeof($whereArray)>0)
		{
			$this->db->where($whereArray);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row_array();
			}
		}
		return false;
		
	}
	function __toString()
	{
		return (string)$this->db->last_query();
	}
}