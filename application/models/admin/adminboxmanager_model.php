<?php

if(!defined('BASEPATH')) exit('Direct script access not allowed');

class adminboxmanager_model extends CI_Model
{
	public function __constrcut()
	{
		parent:: __constrcut();
	}
	function insert_data($section_type,$data,$city_id=0,$category_id=0,$status=0,$sort=0,$name='')
	{
		if($section_type && $data && $name)
		{
			$insert['section_type'] = $section_type;
			$insert['name'] 				= $name;
			$insert['data'] 				= json_encode($data);
			
			if($city_id)
			{
				$insert['city_id']		= $city_id;
			}

			if($category_id)
			{
				$insert['category_id']		= $category_id;
			}
			
			if($status)
			{
				$insert['status'] 		= $status;
			}
			
			if($sort)
			{
				$insert['sort'] 		= $sort;
			}
			
			$rs	=	$this->db->insert('boxmanager', $insert);
			if($rs)
			{
				return $this->db->insert_id();
			}
		}
		return false;
	}

	function update_data($set,$where)
	{
		$this->db->update('boxmanager', $set, $where);
	}

	function __toString()
	{
		return (string)$this->db->last_query();
	}  
}