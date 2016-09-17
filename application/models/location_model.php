<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class location_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function get_state()
	{
		$this->db->select('id,name');
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('states');
		return $query->result();
	}

	function get_city($stateid=0,$a=array())
	{
		$this->db->select('id,name');
		if($stateid){
			$this->db->where('state_id', $stateid);
		}
		
		$this->db->where('status !=', -1);
		
		if(isset($a['status']))
		{
			if(is_array($a['status']) && sizeof($a['status'])>0)
			{
				$this->db->where_in('status', $a['status']);
			}
			else if(strlen($a['status'])>0)
			{
				$this->db->where('status', $a['status']);
			}
		}
		if(isset($a['orderby']))
		{
			$this->db->order_by($a['orderby'][0], $a['orderby'][1]);
		}
		else
		{
			$this->db->order_by('name', 'asc');
		}
		$query = $this->db->get('city');
		return $query->result();
	}
	function get_location($cityid)
	{
		$this->db->select('id,name');
		$this->db->where('status', 1);
		$this->db->where('city_id', $cityid);
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('location');
		return $query->result();
	}

	function get_all_cities()
	{
		$this->db->select('id,name');
		$this->db->where_in('status', array(1,2,0));
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('city');
		return $query->result();
	}
	function get_name_cities()
	{
		$this->db->select('id,name');
		$this->db->where_in('status', array(1,2));
		$this->db->order_by('sort', 'asc');
		$query = $this->db->get('city');
		if($query->num_rows() > 0)
		{
			$data	=	$query->result_array();
			foreach($data as $row)
			{
				$row_data[$row['id']]	=	$row;
			}
			return $row_data;
		}
		return false;		
	}
	function get_locality($cityid)
	{
		$this->db->select('id,name');
		$this->db->where('city_id', $cityid);
		$this->db->order_by('name', 'asc');
		$query = $this->db->get('location');
		return $query->result();
	}

	function insert_location($a = array())
	{
		$insert_query = $this->db->insert_string('location',$a);
		$insert_query = str_replace('INSERT INTO','INSERT IGNORE INTO',$insert_query);
		$rs           = $this->db->query($insert_query);
		if($rs)
		{
			return $this->db->insert_id();
		}
		else
		{
			return false;
		}
	}

	function __toString()
	{
		#return (string)$this->SQL;
		return $this->db->last_query();
	}

	function get_state_id($city_id)
	{
		$this->db->select('state_id');
		$query = $this->db->get_where('city', array('id'=>$city_id));
		if($query->num_rows() >= 1){
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_location_orderby_latlng($lat,$lng,$city_id,$limit=0)
	{
		$this->db->select("lc.id,lc.name,(6371 * ACOS (COS ( RADIANS('".$lat."') ) * COS( RADIANS( lc.latitude ) )
			* COS( RADIANS( lc.longitude ) - RADIANS('".$lng."') )
			+ SIN ( RADIANS('".$lat."') )* SIN( RADIANS( latitude ) ))) AS distance");
		$this->db->order_by('distance');
		if($limit)
		{
			$this->db->limit($limit);
		}
		$query = $this->db->get_where('location as lc', array('city_id'=>$city_id,'status'=>1));

		$location = $query->result_array();
		return $location;

	}
	function distance_by_lat_lng($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

}