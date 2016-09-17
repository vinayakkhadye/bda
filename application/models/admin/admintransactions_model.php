<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class admintransactions_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	function get_transactions($a = array())
	{
		$this->db->start_cache();
		
		$this->db->select('transactions.*, user.name as doctor_name');

		$res = false; 
		$whereArray = array();

		$this->filterData_active($a);
		$this->db->from('transactions');

		if(!empty($a['order_id']))
		{
			$whereArray['transactions.order_id'] = $a['order_id'];
		}
		if(!empty($a['package_type']))
		{
			$whereArray['transactions.package_type'] = $a['package_type'];
		}

		if(!empty($a['doctor_name']))
		{
			$this->db->like("user.name",$a['doctor_name'],'both');
		}
		if(isset($a['order_status']) && strlen($a['order_status'])>0)
		{
			if($a['order_status']==1)
			{
				$whereArray['transactions.order_status'] = 'Success';
			}
			else if($a['order_status']==0)
			{
				$whereArray['transactions.order_status'] = 'Failure';
			}else if($a['order_status']==-1)
			{
				$whereArray['transactions.order_status'] = 'Aborted';
			}
		}
		
		//$this->db->join('packages', 'package_registration.package_id = packages.id');
		$this->db->join('user','user.id = transactions.user_id');

		$this->db->where($whereArray);
		$query = $this->db->get();
		#echo $this->db->last_query();
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
	
	function get_all_transactions()
	{
		$query = $this->db->get_where('transactions', array('id <>' => '1', 'status' => '1'));
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
	}
	
	function check_doctor_package_eligibility($userid, $newpackageid)
	{
		$query = $this->db->get_where('package_registration', array('user_id' => $userid, 'status' => '1', 'end_date >=' => date('Y-m-d')));
//		echo $this->db->last_query();
//		exit;
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

	function get_all_order_details($order_id)
	{
		$this->db->select('transactions.*, transactions_extradetails.*, user.name as usersname, packages.name as package_name');
		$this->db->from('transactions');
		$this->db->join('transactions_extradetails','transactions.order_id = transactions_extradetails.order_id','left');
		$this->db->join('user','transactions.user_id = user.id','left');
		$this->db->join('packages','transactions.package_id = packages.id','left');
		$this->db->where('transactions.order_id', $order_id);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return $query->row_array();
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