<?php
class boxmanager_model extends CI_Model
{
	public function get_data($section_type,$city_id=0,$category_id=0,$status=1,$limit=1,$start=0)
	{
		if($section_type)
		{
			$this->db->select();
			$this->db->from('boxmanager');
			$this->db->where('section_type', $section_type);
			if(strlen($status)>0)
			{
				$this->db->where('status', $status);
			}
			if($city_id)
			{
				$this->db->where('city_id', $city_id);
			}
			if($category_id)
			{
				$this->db->where('category_id', $category_id);
			}			
			$this->db->limit($limit, $start);
			$query = $this->db->get();
			if($query->num_rows > 0)
			{
				foreach($query->result_array() as $key=>$val)
				{
					$rs[$key]					=	$val;
					$rs[$key]['data']	=	json_decode($val['data'],true);
				}
				return $rs;
			}
		}
		return false;
	}

	public function get_data_count($section_type,$city_id=0,$category_id=0)
	{
		if($section_type)
		{
			$this->db->select('data,category_id');
			$this->db->from('boxmanager');
			$this->db->where('section_type', $section_type);
			$this->db->where('status', 1);
			if($city_id)
			{
				$this->db->where('city_id', $city_id);
			}
			if($category_id)
			{
				$this->db->where('category_id', $category_id);
			}			
			return $this->db->count_all_results();
		}
		return false;
	}

	function __toString()
	{
		return (string)$this->db->last_query();
	}
}
?>