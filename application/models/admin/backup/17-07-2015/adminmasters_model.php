<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class adminmasters_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	function get_total_records_count($table_name, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['city_id']) && strlen($search['city_id']) > 0)
		{
			$this->db->where('city_id', $search['city_id']);
		}

		if(isset($search['state_id']) && !empty($search['state_id']))
		{
			$this->db->where('state_id', $search['state_id']);
		}

		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}
		$this->db->from($table_name);
		return $this->db->count_all_results();
	}

	function update_master_status($status, $ids, $tablename)
	{
		if(is_array($ids))
		{
			$this->db->where_in('id', $ids); //$ids should be an array
			$update = array('status'=> $status);
			$this->db->update($tablename, $update);
		}
		return false;
	}

	function update_sort_order($recordid, $sortvalue, $tablename)
	{
		if(is_numeric($sortvalue))
		{
			$this->db->where('id', $recordid);
			$this->db->update($tablename, array('sort'=> $sortvalue));
		}
	}

	function update_stateid($recordid, $stateid)
	{
		if(is_numeric($stateid))
		{
			$this->db->where('id', $recordid);
			$this->db->update('city', array('state_id'=> $stateid));
		}
	}

	function update_countryid($recordid, $countryid)
	{
		if(is_numeric($countryid))
		{
			$this->db->where('id', $recordid);
			$this->db->update('states', array('country_id'=> $countryid));
		}
	}

	function update_record_name($recordid, $recordvalue, $tablename)
	{
		if(is_numeric($recordid) && !empty($recordid) && !empty($recordvalue) && !empty($tablename))
		{
			$this->db->where('id', $recordid);
			$this->db->update($tablename, array('name'=> $recordvalue));
		}
	}

	function add_new_record($postdata, $tablename)
	{
		$data = array(
			'name'		=>	$postdata['new_record_name'],
			'created_on'=>	date('Y-m-d h:i:s')
			);
		if(isset($postdata['new_record_status']) && strlen($postdata['new_record_status']) > 0)
		{
			$data['status'] = $postdata['new_record_status'];
		}
		if(isset($postdata['new_sort_order']) && !empty($postdata['new_sort_order']))
		{
			$data['sort'] = $postdata['new_sort_order'];
		}
		if(isset($postdata['new_record_cityid']) && !empty($postdata['new_record_cityid']) && is_numeric($postdata['new_record_cityid']))
		{
			$data['city_id'] = $postdata['new_record_cityid'];
		}
		if(isset($postdata['new_record_longitude']) && !empty($postdata['new_record_longitude']) && is_numeric($postdata['new_record_longitude']))
		{
			$data['longitude'] = $postdata['new_record_longitude'];
		}
		if(isset($postdata['new_record_latitude']) && !empty($postdata['new_record_latitude']) && is_numeric($postdata['new_record_latitude']))
		{
			$data['latitude'] = $postdata['new_record_latitude'];
		}
		if(isset($postdata['new_record_stateid']) && !empty($postdata['new_record_stateid']) && is_numeric($postdata['new_record_stateid']))
		{
			$data['state_id'] = $postdata['new_record_stateid'];
		}

		if(isset($postdata['new_record_id']) && !empty($postdata['new_record_id']) && is_numeric($postdata['new_record_id']))
		{
			$data['id'] = $postdata['new_record_id'];
		}
		if(isset($postdata['new_record_usertype']) && !empty($postdata['new_record_usertype']) && is_numeric($postdata['new_record_usertype']))
		{
			$data['user_type'] = $postdata['new_record_usertype'];
		}
		if(isset($postdata['new_sort_amount']) && !empty($postdata['new_sort_amount']) && is_numeric($postdata['new_sort_amount']))
		{
			$data['price'] = $postdata['new_sort_amount'];
		}
		if(in_array($tablename,array( 'location','speciality')))
		{
			$data['url_name'] = url_string($postdata['new_record_name']);
		}

		$this->db->insert($tablename, $data);
		//echo $this->db->last_query();
	}

	function get_qualifications_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}

		$this->db->from('qualification');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_speciality_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}

		$this->db->from('speciality');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_states_list($limit=0, $start=0, $search = array())
	{
		if(isset($search['column']) && is_array($search['column']))
		{
			$this->db->select(implode(",",$search['column']));
		}
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}

		$this->db->from('states');
		if($limit && $start)
		{
			$this->db->limit($limit, $start);
		}
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_country_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}

		$this->db->from('country');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_city_master()
	{
		$this->db->from('city');
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_city_list($limit=0, $start=0, $search = array())
	{
		if(isset($search['column']) && is_array($search['column']))
		{
			$this->db->select(implode(",",$search['column']));
		}

		if(isset($search['status']))
		{
			if(is_array($search['status']) && sizeof($search['status'])>0)
			{
				$this->db->where_in('status', $search['status']);
			}
			else if(strlen($search['status']) > 0)
			{
				$this->db->where('status', $search['status']);
			}
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}
		if(isset($search['state_id']) && !empty($search['state_id']))
		{
			$this->db->where('state_id', $search['state_id']);
		}

		$this->db->from('city');
		if($limit && $start)
		{
			$this->db->limit($limit, $start);
		}
		$query = $this->db->get();
		#echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_services_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}

		$this->db->from('services');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_location_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['city_id']) && strlen($search['city_id']) > 0)
		{
			$this->db->where('city_id', $search['city_id']);
		}

		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}

		$this->db->from('location');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_council_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}

		$this->db->from('council');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_memberships_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}

		$this->db->from('memberships');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_college_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}

		$this->db->from('college');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function get_packages_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && strlen($search['status']) > 0)
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['record_name']) && !empty($search['record_name']))
		{
			$this->db->like('name', $search['record_name'], 'both');
		}

		$this->db->from('packages');
		$this->db->limit($limit, $start);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;	
		}
	}

	function update_package_usertype($recordid, $value)
	{
		if(is_numeric($value))
		{
			$this->db->where('id', $recordid);
			$this->db->update('packages', array('user_type'=> $value));
		}
	}

	function update_package_amount($recordid, $value)
	{
		if(is_numeric($value))
		{
			$this->db->where('id', $recordid);
			$this->db->update('packages', array('price'=> $value));
		}
	}

	function update_city_id($recordid, $cityid)
	{
		if(is_numeric($cityid))
		{
			$this->db->where('id', $recordid);
			$this->db->update('location', array('city_id'=> $cityid));
		}
	}

	function update_longitude($recordid, $longitude)
	{
		if(is_numeric($longitude))
		{
			$this->db->where('id', $recordid);
			$this->db->update('location', array('longitude'=> $longitude));
		}
	}

	function update_latitude($recordid, $latitude)
	{
		if(is_numeric($latitude))
		{
			$this->db->where('id', $recordid);
			$this->db->update('location', array('latitude'=> $latitude));
		}
	}
	
	function get_active_locality_master()
	{
		$this->db->select('id,name');
		$this->db->from('location');
		$this->db->where('status', 1);
		$this->db->order_by('name', 'asc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}
	
	function __toString()
	{
		return (string)$this->db->last_query();
	}
}