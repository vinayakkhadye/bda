<?php
if(!defined('BASEPATH')) exit('No direct access allowed');

class adminadvertisements_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/admindoctor_model');
	}

	function get_total_records_count($table_name='campaigns', $search = array())
	{
		if(isset($search['status']) && !empty($search['status']))
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['company_name']) && !empty($search['company_name']))
		{
			$this->db->like('company_name', $search['company_name'], 'both');
		}
		$this->db->from($table_name);
		$count = $this->db->count_all_results();
		$this->db->last_query();
		return $count;
	}

	function update_campaign_status($status, $ids)
	{
		if(is_array($ids))
		{
			$this->db->where_in('id', $ids); //$ids should be an array
			$update = array('status'=> $status);
			$this->db->update('campaigns', $update);
		}
		return false;
	}
	
	function get_doctors_list($search = array())
	{
		$where = NULL;
		
		$this->db->select('d.name as doctor_name, d.id as doctor_id, c.name as city_name, d.speciality AS speciality_ids, d.user_id as user_id');
		$this->db->from('doctor d');
		$this->db->join('clinic cl', 'd.id=cl.doctor_id', 'left');
		$this->db->join('city c', 'c.id=cl.city_id');
		
		
		if(isset($search['speciality_id']) && !empty($search['speciality_id']))
		{
			$where.= "(d.speciality LIKE '".$search['speciality_id']."' OR d.speciality LIKE '".$search['speciality_id'].",%' OR d.speciality LIKE '%,".$search['speciality_id']."'  OR d.speciality LIKE '%,".$search['speciality_id'].",%') ";
			$this->db->where($where);
		}
		if(isset($search['city_id']) && !empty($search['city_id']))
		{
			$this->db->where('cl.city_id', $search['city_id']);
		}
		if(isset($search['doctor_name']) && !empty($search['doctor_name']))
		{
			$this->db->like('d.name', $search['doctor_name'], 'both');
		}
		$this->db->group_by('d.name');
		
		$query = $this->db->get();
//		echo $this->db->last_query();
	
		if($query->num_rows() > 0)
		{
			$final['docdata'] = $query->result_array();
			$ids = array();
			foreach($final['docdata'] as $key)
			{
				$specids = explode(',',$key['speciality_ids']);
				foreach($specids as $value)
				{
					if(!in_array($value, $ids))
					{
						array_push($ids, $value);
					}
				}
			}
			// Get Packages names
			foreach($final['docdata'] as $key=>$value)
			{
				$this->db->select('group_concat(DISTINCT p.name) as packages_name');
				$this->db->from('package_registration pr');
				$this->db->join('packages p', 'p.id=pr.package_id', 'left');
				$this->db->where('pr.user_id', $value['user_id']);
				$query = $this->db->get();
				if($query->num_rows() > 0)
				{
					$res = $query->row_array();
					$final['docdata'][$key]['packages_name'] = $res['packages_name'];
				}
			}
			
			// Get the speciality
			$this->db->select('id,name');
			$this->db->from('speciality');
			$this->db->where_in('id', $ids);
			$query2 = $this->db->get();
//			echo $this->db->last_query();
			if($query2->num_rows() > 0)
			{
				$final['specdata'] = $query2->result_array();
			}
			else
			{
				$final['specdata'] = NULL;
			}
			
			//print_r($final['specdata']);
			
			foreach($final['docdata'] as $key=>$value)
			{
				/*
				var_dump($key);
				echo "<br>";
				var_dump($value);
				echo "<br><br>";
				*/
				//echo $value['speciality_ids'].'<br/><br/>';
				$temp_specs = NULL;
				$specids = explode(',',$value['speciality_ids']);
				foreach($specids as $values)
				{
					/*
					print_r($values);
					echo "<br><br>";
					*/
					foreach($final['specdata'] as $spid)
					{
						if($values == $spid['id'])
						{
							$temp_specs.= ucfirst($spid['name']).', ';
						}
					}
				}
				$final['docdata'][$key]['speciality_name'] = trim($temp_specs,', ');
			}
			
//			print_r($final);
			return $final;
		}
		else
		{
			return FALSE;	
		}
	}
	
	function get_campaigns_list($limit, $start, $search = array())
	{
		if(isset($search['status']) && !empty($search['status']))
		{
			$this->db->where('status', $search['status']);
		}
		if(isset($search['company_name']) && !empty($search['company_name']))
		{
			$this->db->like('company_name', $search['company_name'], 'both');
		}
		
		if(isset($search['start_date_from']) && !empty($search['start_date_from']))
		{
			$this->db->where('start_date >=', date('Y-m-d',strtotime($search['start_date_from'])));
		}
		
		if(isset($search['start_date_to']) && !empty($search['start_date_to']))
		{
			$this->db->where('start_date <=', date('Y-m-d',strtotime($search['start_date_to'])));
		}
		
		$this->db->from('campaigns');
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
	
	function add_campaign($postdata)
	{
		$postdata['end_date'] = date('Y-m-d', strtotime($postdata['start_date'].' +'.$postdata['no_of_days'].'days'));
		//exit;
		$data = array(
			'campaign_name'=>$postdata['campaign_name'],
			'company_name'=>$postdata['company_name'],
			'division'=>$postdata['division'],
			'contact_name'=>$postdata['contact_name'],
			'contact_number'=>$postdata['contact_number'],
			'contact_email'=>$postdata['contact_email'],
			'start_date'=>date('Y-m-d', strtotime($postdata['start_date'])),
			'end_date'=>$postdata['end_date'],
			'no_of_days'=>$postdata['no_of_days'],
			'status'=>$postdata['status'],
			'brand_name'=>$postdata['brand_name'],
			'no_of_doctors'=>$postdata['no_of_doctors'],
			'package_id'=>$postdata['package_id'],
			//'ad_img_lres'=>$postdata['ad_img_lres'],
			//'ad_img_mres'=>$postdata['ad_img_mres'],
			//'ad_img_hres'=>$postdata['ad_img_hres'],
			//'ad_img_ures'=>$postdata['ad_img_ures'],
			'created_by'=>$this->session->userdata('admin_name'),
			'created_on'=>date('Y-m-d h:i:s')
		);
		$this->db->insert('campaigns', $data);
		return $this->db->insert_id();
	}
	
	function update_campaign($postdata)
	{
		$postdata['end_date'] = date('Y-m-d', strtotime($postdata['start_date'].' +'.$postdata['no_of_days'].'days'));
		
		$data = array(
			'campaign_name'=>$postdata['campaign_name'],
			'company_name'=>$postdata['company_name'],
			'division'=>$postdata['division'],
			'contact_name'=>$postdata['contact_name'],
			'contact_number'=>$postdata['contact_number'],
			'contact_email'=>$postdata['contact_email'],
			'start_date'=>date('Y-m-d', strtotime($postdata['start_date'])),
			'end_date'=>$postdata['end_date'],
			'no_of_days'=>$postdata['no_of_days'],
			'status'=>$postdata['status'],
			'brand_name'=>$postdata['brand_name'],
			'no_of_doctors'=>$postdata['no_of_doctors'],
			'package_id'=>$postdata['package_id'],
			'updated_by'=>$this->session->userdata('admin_name'),
			'updated_on'=>date('Y-m-d h:i:s')
		);
		$this->db->where('id', $postdata['campaign_id']);
		$this->db->update('campaigns', $data);
	}
	
	function update_filenames($campaign_id, $postdata)
	{
		$data = array();
		foreach($postdata as $key=>$value)
		{
			$data[$key] = $value;
		}
		$this->db->where('id', $campaign_id);
		$this->db->update('campaigns', $data);
	}
	
	function insert_filenames($campaign_id, $postdata)
	{
		print_r($postdata);
		$data = array(
			'ad_img_lres'=>$postdata['ad_img_lres'],
			'ad_img_mres'=>$postdata['ad_img_mres'],
			'ad_img_hres'=>$postdata['ad_img_hres'],
			'ad_img_ures'=>$postdata['ad_img_ures']
		);
		$this->db->where('id', $campaign_id);
		$this->db->update('campaigns', $data);
	}
	
	function get_all_details_campaign($campaign_id)
	{
		$this->db->select('campaigns.*, packages.name as package_name');
		$this->db->from('campaigns');
		$this->db->join('packages', 'packages.id = campaigns.package_id');
		$this->db->where('campaigns.id', $campaign_id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function delete_image($imgdata)
	{
		$data = array(
			$imgdata['imgtype'] =>	NULL,
			'updated_on'  =>	date('Y-m-d h:i:s'),
			'updated_by'  =>	$this->session->userdata('admin_name')
		);
		$this->db->where('id', $imgdata['campaignid']);
		$this->db->update('campaigns', $data);
	}

	function get_no_of_doctors($campaign_id)
	{
		$this->db->select('no_of_doctors');
		$this->db->from('campaigns');
		$this->db->where('id', $campaign_id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->row_array();
		}
		else
		{
			return FALSE;
		}
	}
	
	function get_campaign_doctors($campaign_id=0,$doctor_id=0)
	{
		if($campaign_id)
		{
			$src_array['campaign_id']	=	$campaign_id;
		}
		if($doctor_id)
		{
			$src_array['doctor_id']	=	$doctor_id;
		}
		
		return $query = $this->db->get_where('campaign_doctors', $src_array)->result_array();
	}
	
	function add_doctor_to_campaign($doctor_id, $campaign_id, $postdata)
	{
		$data = array(
			'doctor_id'  =>	$doctor_id,
			'campaign_id'=>	$campaign_id,
			'doctor_name'=>	$postdata['docname'],
			'speciality_name'=>	$postdata['specname'],
			'city_name'=>	$postdata['cityname'],
			'created_on'   =>	date('Y-m-d h:i:s'),
			'updated_on' =>	date('Y-m-d h:i:s'),
			'created_by' =>	$this->session->userdata('admin_name'),
			'updated_by' =>	$this->session->userdata('admin_name')
		);
		$this->db->insert('campaign_doctors', $data);
	}
	
	function remove_doctor_from_campaign($doctor_id, $campaign_id)
	{
		$this->db->where('campaign_id', $campaign_id);
		$this->db->where('doctor_id', $doctor_id);
		$this->db->delete('campaign_doctors');
	}
	
	function check_doctor_present_in_campaigns($doctor_id)
	{
		$this->db->from('campaign_doctors');
		$this->db->join('campaigns', 'campaigns.id = campaign_doctors.campaign_id', 'left');
		$this->db->where('campaign_doctors.doctor_id', $doctor_id);
		$this->db->where('campaigns.status !=', 'C');
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return FALSE;
		}
	}
	
	function check_doctor_paid_packages($doctor_id)
	{
		$this->db->from('campaign_doctors');
		$this->db->join('doctor', 'doctor.id = campaign_doctors.doctor_id', 'left');
		$this->db->join('package_registration', 'doctor.user_id = package_registration.user_id');
		$this->db->where('campaign_doctors.doctor_id', $doctor_id);
		$this->db->where('package_registration.package_id >', '20');
		$this->db->where('package_registration.package_id <', '100');
		$query = $this->db->get();
//		echo $this->db->last_query();
		if($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function activate_doctor_package_campaign($doctor_id, $campaign_id, $userid)
	{
		$this->db->from('campaigns');
		$this->db->where('id', $campaign_id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$rowvalues = $query->row();
			if($rowvalues->package_id > 20 && $rowvalues->package_id < 100)
			{
				$data2 = array(
					'user_id'		=>	$userid,
					'user_type'		=>	'2',
					'package_id'	=>	$rowvalues->package_id,
					'start_date'	=>	date('Y-m-d'),
					'end_date'		=>	date('Y-m-d', strtotime("+".$rowvalues->no_of_days."days -1 days")),
					'amount_paid'	=>	'0',
					'status'		=>	'1'
					);
				$this->db->insert('package_registration', $data2);
				
				$data = array(
					'activated'     =>	1,
					'updated_on'       =>	date('Y-m-d h:i:s'),
					'updated_by' =>	$this->session->userdata('admin_name')
				);
				$this->db->where('campaign_id', $campaign_id);
				$this->db->where('doctor_id', $doctor_id);
				$this->db->update('campaign_doctors', $data);
	//			echo $this->db->last_query();
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
	
	function check_doctor_userid_exists($doctor_id)
	{
		$this->db->select('user_id');
		$this->db->from('doctor');
		$this->db->where('id', $doctor_id);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			$rowvalue = $query->row();
			if(empty($rowvalue->user_id))
			{
				return FALSE;
			}
			else
			{
				return $rowvalue->user_id;
			}
		}
		else
		{
			return FALSE;
		}
	}
	
}