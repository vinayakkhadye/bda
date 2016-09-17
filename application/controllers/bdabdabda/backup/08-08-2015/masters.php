<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Masters extends CI_Controller
{
	private $current_tab = 'masters';
	public $perms	=	array();	
	
	function __construct()
	{
		parent::__construct();
		$this->load->library("pagination");
		$this->load->helper("url");
		$this->load->model(array('admin/adminmasters_model','location_model'));

		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if($this->perms[ADMIN_MASTERS]['view']	==	0)
		{
			redirect($admin_home_url);
			exit();
		}
	}

	function index()
	{
		$data['current_tab'] = $this->current_tab;
		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_main', $data);
	}

	function update_sort($tablename = NULL)
	{
		if($tablename != NULL)
		{
			$recordid = $_POST['recordid'];
			$sortvalue = $_POST['sortvalue'];
			if(is_numeric($recordid) && is_numeric($sortvalue) && !empty($recordid) && !empty($sortvalue))
			{
				$this->adminmasters_model->update_sort_order($recordid, $sortvalue, $tablename);
			}
		}
	}

	function update_name($tablename = NULL)
	{
		if($tablename != NULL)
		{
			$recordid = $_POST['recordid'];
			$recordvalue = $_POST['recordvalue'];
			if(is_numeric($recordid) && !empty($recordid) && !empty($recordvalue))
			{
				$this->adminmasters_model->update_record_name($recordid, $recordvalue, $tablename);
				echo $this->adminmasters_model;
			}
		}
	}

	function update_status($status, $tablename)
	{
		if(isset($this->post['record_id']) && is_array($this->post['record_id']) && sizeof($this->post['record_id'])>0)
		{
			$ids = array_keys($this->post['record_id']);
			$this->adminmasters_model->update_master_status($status, $ids, $tablename);
		}
	}

	function qualification()
	{
		$data['current_tab'] = $this->current_tab;

		$config['base_url'] = BASE_URL.'bdabdabda/masters/qualification?';
		$config['per_page'] = 50;
		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		$search = array();
		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'qualification');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'qualification');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'qualification');
			}
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'qualification');
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('qualification', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_qualifications_list($config["per_page"], $page, $search);
		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_qualification', $data);
	}
	
	function speciality()
	{
		$data['current_tab'] = $this->current_tab;

		$config['base_url'] = BASE_URL.'bdabdabda/masters/speciality?';
		$config['per_page'] = 50;

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;

		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'speciality');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'speciality');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'speciality');
			}
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'speciality');
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
		}
		else
		{
			$search = NULL;
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('speciality', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_speciality_list($config["per_page"], $page, $search);
		
		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_speciality', $data);
	}

	function country()
	{
		$data['current_tab'] = $this->current_tab;
		$config['base_url'] = BASE_URL.'bdabdabda/masters/country?';
		$config['per_page'] = 50;

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;

		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'country');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'country');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'country');
			}
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'country');
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
		}
		else
		{
			$search = NULL;
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('country', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_country_list($config["per_page"], $page, $search);
		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_country', $data);
	}

	function states()
	{
		$data['current_tab'] = $this->current_tab;
		
		$config['base_url'] = BASE_URL.'bdabdabda/masters/states?';
		$config['per_page'] = 50;

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;

		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'states');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'states');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'states');
			}
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'states');
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
		}
		else
		{
			$search = NULL;
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('states', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_states_list($config["per_page"], $page, $search);
		
		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_states', $data);
	}


	function city()
	{
		$data['current_tab'] = $this->current_tab;

		$config['base_url'] = BASE_URL.'bdabdabda/masters/city?';
		$config['per_page'] = 50;

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;

		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'city');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'city');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'city');
			}
			if($_POST['submit'] == 'OtherCity')
			{
				$this->update_status('2', 'city');
			}

			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'city');
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
			if(isset($_GET['stateid']) && !empty($_GET['stateid']))
			{
				$search['state_id'] = $_GET['stateid'];
			}
		}
		else
		{
			$search = NULL;
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('city', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_city_list($config["per_page"], $page, $search);
		$data['state_list'] = $this->adminmasters_model->get_states_list(0, 0, array('status'=>1,'column'=>array('id','name')));
		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_city', $data);
	}

	function services()
	{
		$data['current_tab'] = $this->current_tab;

		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] = TRUE;

		
		$config['base_url'] = BASE_URL.'bdabdabda/masters/services?';
		$config['per_page'] = 50;
		$config["uri_segment"] = 4;
		$config['num_links'] = 5;
		$config['query_string_segment'] = 'start';

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;

		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'services');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'services');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'services');
			}
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'services');
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
		}
		else
		{
			$search = NULL;
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('services', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_services_list($config["per_page"], $page, $search);
		
		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_services', $data);
	}

	function council()
	{
		$data['current_tab'] = $this->current_tab;

		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] = TRUE;

		
		$config['base_url'] = BASE_URL.'bdabdabda/masters/council?';
		$config['per_page'] = 50;
		$config["uri_segment"] = 4;
		$config['num_links'] = 5;
		$config['query_string_segment'] = 'start';

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;

		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'council');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'council');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'council');
			}
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'council');
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
		}
		else
		{
			$search = NULL;
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('council', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_council_list($config["per_page"], $page, $search);
		
		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_council', $data);
	}

	function memberships()
	{
		$data['current_tab'] = $this->current_tab;

		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] = TRUE;

		
		$config['base_url'] = BASE_URL.'bdabdabda/masters/memberships?';
		$config['per_page'] = 50;
		$config["uri_segment"] = 4;
		$config['num_links'] = 5;
		$config['query_string_segment'] = 'start';

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;

		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'memberships');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'memberships');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'memberships');
			}
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'memberships');
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
		}
		else
		{
			$search = NULL;
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('memberships', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_memberships_list($config["per_page"], $page, $search);

		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_memberships', $data);
	}

	function college()
	{
		$data['current_tab'] = $this->current_tab;

		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] = TRUE;

		
		$config['base_url'] = BASE_URL.'bdabdabda/masters/college?';
		$config['per_page'] = 50;
		$config["uri_segment"] = 4;
		$config['num_links'] = 5;
		$config['query_string_segment'] = 'start';

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;

		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'college');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'college');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'college');
			}
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'college');
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
		}
		else
		{
			$search = NULL;
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('college', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_college_list($config["per_page"], $page, $search);

		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_college', $data);
	}

	function location()
	{
		$data['current_tab'] = $this->current_tab;

		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] = TRUE;

		$config['base_url'] = BASE_URL.'bdabdabda/masters/location?';
		$config['per_page'] = 50;
		$config["uri_segment"] = 4;
		$config['num_links'] = 5;
		$config['query_string_segment'] = 'start';

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;

		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'location');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'location');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'location');
			}
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'location');
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['city_id']) && strlen($_GET['city_id']) > 0)
			{
				$search['city_id'] = $_GET['city_id'];
			}
			
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
		}
		else
		{
			$search = NULL;
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('location', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_location_list($config["per_page"], $page, $search);
		$data['city'] = $this->location_model->get_all_cities();

		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_location', $data);
	}
	
	function packages()
	{
		$data['current_tab'] = $this->current_tab;

		$config['base_url'] = BASE_URL.'bdabdabda/masters/packages?';
		$config['per_page'] = 50;

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;

		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'packages');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'packages');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'packages');
			}
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				if(!empty($_POST['new_record_name']))
				{
					$this->adminmasters_model->add_new_record($_POST, 'packages');
					echo $this->adminmasters_model;
				}
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['record_name']) && !empty($_GET['record_name']))
			{
				$search['record_name'] = $_GET['record_name'];
			}
		}
		else
		{
			$search = NULL;
		}

		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('packages', $search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_packages_list($config["per_page"], $page, $search);

		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_packages', $data);
	}
	
	function raw_sms_log()
	{
		$data['current_tab'] = $this->current_tab;

		$config['base_url'] = BASE_URL.'bdabdabda/masters/raw_sms_log?';
		$config['per_page'] = 50;
		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		$config['total_rows'] = $this->adminmasters_model->get_total_records_count('raw_sms_log', $_GET);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminmasters_model->get_raw_sms_log_list($config["per_page"], $page, $_GET);
		$data['perms']	=	$this->perms;
		$this->load->view('admin/masters_raw_sms_log', $data);
	}	
	function update_package_amount()
	{
		$recordid = $_POST['recordid'];
		$value = $_POST['value'];
		if(is_numeric($recordid) && is_numeric($value) && !empty($recordid) && is_numeric($value))
		{
			$this->adminmasters_model->update_package_amount($recordid, $value);
		}
	}
	
	function update_package_usertype()
	{
		$recordid = $_POST['recordid'];
		$value = $_POST['value'];
		if(is_numeric($recordid) && is_numeric($value) && !empty($recordid) && is_numeric($value))
		{
			$this->adminmasters_model->update_package_usertype($recordid, $value);
		}
	}
	
	function update_cityid()
	{
		$recordid = $_POST['recordid'];
		$cityid = $_POST['cityid'];
		if(is_numeric($recordid) && is_numeric($cityid) && !empty($recordid) && !empty($cityid))
		{
			$this->adminmasters_model->update_city_id($recordid, $cityid);
		}
	}
	
	function update_countryid()
	{
		$recordid = $_POST['recordid'];
		$countryid = $_POST['countryid'];
		if(is_numeric($recordid) && is_numeric($countryid) && !empty($recordid) && !empty($countryid))
		{
			$this->adminmasters_model->update_countryid($recordid, $countryid);
		}
	}
	
	function update_longitude()
	{
		$recordid = $_POST['recordid'];
		$longitude = $_POST['longitude'];
		if(is_numeric($recordid) && is_numeric($longitude) && !empty($recordid) && !empty($longitude))
		{
			$this->adminmasters_model->update_longitude($recordid, $longitude);
		}
	}
	
	function update_latitude()
	{
		$recordid = $_POST['recordid'];
		$latitude = $_POST['latitude'];
		if(is_numeric($recordid) && is_numeric($latitude) && !empty($recordid) && !empty($latitude))
		{
			$this->adminmasters_model->update_latitude($recordid, $latitude);
		}
	}

	function update_stateid()
	{
		$recordid = $_POST['recordid'];
		$stateid = $_POST['stateid'];
		if(is_numeric($recordid) && is_numeric($stateid) && !empty($recordid) && strlen($stateid) >0)
		{
			$this->adminmasters_model->update_stateid($recordid, $stateid);
		}
	}
	
}