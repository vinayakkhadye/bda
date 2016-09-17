<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class adminalluser_model extends CI_Model
{	
	public function __construct()
	{
		parent::__construct();
	}

	function user_view(	$a = array())
	{
 
		$this->db->select('*'); 
		$res = false; 
		$whereArray = array();
		$this->filterData_active($a);
		$this->db->from('user');

		if(!empty($a['id']))
		{
			$whereArray['id'] = $a['id'];
		}
		if(!empty($a['name']))
		{
			$this->db->like('name',$a['name'],'both');
		}
		if(!empty($a['user_email']))
		{
			$this->db->like('email_id',$a['user_email'],'both');
		}
		if(!empty($a['contact']))
		{
			$whereArray['contact_number'] = $a['contact'];
		}
		if(!empty($a['gender']))
		{
			$this->db->like('gender',$a['gender'],'both');
		}
		if(!empty($a['type']))
		{
			$whereArray['type'] = $a['type'];
		}
		if(!empty($a['verified']))
		{
			$whereArray['is_verified'] = $a['verified'];
		} 
 
		// $this->db->limit($limit,$offset);
		$this->db->where($whereArray);
		$query = $this->db->get();
		#echo $this->db->last_query();
		
		if($query->num_rows() >= 1)
		{
			$res = $query->result();
		}
		
		return $res;
	}

	function view_user_count($a = array())
	{

		$res = false; 
		$whereArray = array();
		$this->filterData_active($a);
		$this->db->from('user');
		

   	 	// $this->db->limit($limit,$offset);
    	$count = $this->db->count_all_results();
    	 
        return $count; 
	}

}