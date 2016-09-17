<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class adminpackages_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	// Get the list of all packages of users
	function get_packages($a = array())
	{
		$this->db->start_cache();
		
		$this->db->select('package_registration.*, user.name as doctor_name, packages.name as package_name');

		$res = false; 
		$whereArray = array();

		$this->filterData_active($a);
		$this->db->from('package_registration');

		if(!empty($a['doctor_id']))
		{
			$whereArray['doctor.id'] = $a['doctor_id'];
			$this->db->join('doctor','doctor.user_id = package_registration.user_id');
		}
		if(!empty($a['doctor_name']))
		{
			$this->db->like("user.name",$a['doctor_name'],'both');
		}
		if(isset($a['status']) && strlen($a['status']) > 0)
		{
			$whereArray['package_registration.status'] = $a['status'];
		}
		
		$this->db->join('packages', 'package_registration.package_id = packages.id');
		$this->db->join('user','user.id = package_registration.user_id');
		#$this->db->where('package_registration.status', '1');
		#$this->db->where('package_registration.end_date >=', date('Y-m-d'));
		$this->db->where('package_registration.package_id >', '1');
		
		$this->db->where($whereArray);
		$query = $this->db->get();
//		echo $this->db->last_query();
		//echo $this->adminreview_model;
		$this->row_count = $this->db->count_all_results();
		$this->db->stop_cache();
		$this->db->flush_cache();
		
		if($query->num_rows() >= 1)
		{
			$res = $query->result();
		}
		
		return $res;
	}
	
	// To get the list of all packages we offer
	function get_all_packages($existing_packages)
	{
		$this->db->from('packages');
		$this->db->where('id <>','1');
		$this->db->where('status','1');
		$this->db->where_not_in('id', $existing_packages);
		$query = $this->db->get();
//		echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	function get_all_packages_list()
	{
		$this->db->from('packages');
		$this->db->where('id <>','1');
		$this->db->where('id <>','0');
		$this->db->where('status','1');
		$query = $this->db->get();
//		echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			return FALSE;
		}
	}

	function get_package_details_by_packageid($package_registration_id)
	{
		$this->db->select('package_registration.*, packages.name, packages.id as package_master_id, package_registration.status as current_status');
		$this->db->from('package_registration');
		$this->db->join('packages','package_registration.package_id = packages.id','left');
		$this->db->where('package_registration.id', $package_registration_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}

	function update_package_alloted_details($package_registration_id, $postdata)
	{
		$data = array(
			'package_id'	=>$postdata['packageid'],
			'start_date'	=>date('Y-m-d', strtotime($postdata['start_date'])),
			'end_date'		=>date('Y-m-d', strtotime($postdata['end_date'])),
			'amount_paid'	=>$postdata['amount'],
			'status'		=>$postdata['status'],
			'updated_on'	=>date('Y-m-d h:i:s')
		);
		$this->db->where('id', $package_registration_id);
		$this->db->update('package_registration', $data);
		//echo $this->db->last_query();
	}

	function insert_package($userid, $packageid, $start_date, $end_date)
	{
		$data2 = array(
			'user_id'		=>	$userid,
			'user_type'		=>	'2',
			'package_id'	=>	$packageid,
			'start_date'	=>	date('Y-m-d', strtotime($start_date)),
			'end_date'		=>	date('Y-m-d', strtotime($end_date)),
			'amount_paid'	=>	'0',
			'status'		=>	'1'
			);
		$this->db->insert('package_registration', $data2);
		return $this->db->insert_id();
	}
	
	function check_doctor_package_eligibility($userid, $newpackageid=0)
	{
		$query = $this->db->get_where('package_registration', array('user_id' => $userid, 'status' => '1', 'end_date >=' => date('Y-m-d')));
		echo $this->db->last_query();
		exit;
		if($query->num_rows() > 0)
		{
			$results = $query->result();
			$packageids = array();
//			print_r($results);
			foreach($results as $result)
			{
				// get all the package ids in an array
				array_push($packageids, $result->package_id);
			}
			// Sort package ids in descending order
			arsort($packageids);
			// Check if smart receptionist is present as a current package or not
			if(in_array('40', $packageids)) // Smart receptionist is present
			{
				// Remove the 1st package id i.e.40 (smart receptionist)
				array_shift($packageids);
				// Check if new package id is greater than the max of current package which the doctor holds
				if((($newpackageid > max($packageids))) && $newpackageid != '40') 
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				if(($newpackageid > max($packageids)))
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}
		else
		{
			return FALSE;
		}
	}

	function get_user_packages($userid)
	{
		$this->db->select('package_registration.*, packages.name as package_name');
		$this->db->from('package_registration');
		$this->db->join('packages', 'package_registration.package_id = packages.id');
		$this->db->where('package_registration.package_id >', '1');
		$this->db->where('package_registration.status <>', '-1');
		#$this->db->where('package_registration.status', '1');
		$this->db->where('package_registration.user_id', $userid);
		$this->db->order_by('package_registration.end_date', 'desc');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function __toString()
	{
		return $this->db->last_query();
	}

}