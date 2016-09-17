<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advertisements extends CI_Controller
{
	private $current_tab = 'advertisements';

	function __construct()
	{
		parent::__construct();
		$this->load->model(array('admin/adminadvertisements_model','page_model'));
		$this->load->library("pagination");
		$this->load->helper("url");
		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if($this->perms[ADMIN_ADVERTISE]['view']	==	0)
		{
			redirect(($admin_home_url)?$admin_home_url:'/bdabdabda');
			exit();
		}

	}

	function index()
	{
		$data['current_tab'] = $this->current_tab;

		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] = TRUE;


		$config['base_url'] = BASE_URL.'bdabdabda/advertisements?';
		$config['per_page'] = 50;
		$config["uri_segment"] = 4;
		$config['num_links'] = 5;
		$config['query_string_segment'] = 'start';

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}

		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		$search = array();
		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Active')
			{
				$this->update_status('A');
			}
			elseif($_POST['submit'] == 'Draft')
			{
				$this->update_status('D');
			}
			elseif($_POST['submit'] == 'Suspended')
			{
				$this->update_status('S');
			}
			elseif($_POST['submit'] == 'Completed')
			{
				$this->update_status('C');
			}
		}

		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && !empty($_GET['status']))
			{
				$search['status'] = $_GET['status'];
			}
			if(isset($_GET['company_name']) && !empty($_GET['company_name']))
			{
				$search['company_name'] = $_GET['company_name'];
			}
			if(isset($_GET['start_date_from']) && !empty($_GET['start_date_from']))
			{
				$search['start_date_from'] = urldecode($_GET['start_date_from']);
			}
			if(isset($_GET['start_date_to']) && !empty($_GET['start_date_to']))
			{
				$search['start_date_to'] = urldecode($_GET['start_date_to']);
			}
		}

		$config['total_rows'] = $this->adminadvertisements_model->get_total_records_count('campaigns', $search);
		$this->pagination->initialize($config);
		$data['allrecords'] = $this->adminadvertisements_model->get_campaigns_list($config["per_page"], $page, $search);
		
		$data['perms']	=	$this->perms;
		$this->load->view('admin/advertisements', $data);
	}

	function update_status($status)
	{
		$ids = array_keys($this->post['record_id']);
		$this->adminadvertisements_model->update_campaign_status($status, $ids);
	}

	function view_campaign($campaign_id = NULL)
	{
		$this->data['current_tab'] = $this->current_tab;

		if($campaign_id == NULL)
		{
			redirect('/bdabdabda/advertisements');
			exit();
		}
		else
		{
			$this->data['all_details'] = $this->adminadvertisements_model->get_all_details_campaign($campaign_id);
			$this->data['perms']	=	$this->perms;
			$this->load->view('admin/advertisements_viewcampaign', $this->data);
		}
	}

	function editcampaign($campaign_id = NULL)
	{
		$this->load->model('admin/adminpackages_model');
		$this->data['current_tab'] = $this->current_tab;
		$this->data['packages'] = $this->adminpackages_model->get_all_packages_list();
		$this->data['all_details'] = $this->adminadvertisements_model->get_all_details_campaign($campaign_id);

		if($campaign_id == NULL)
		{
			redirect('/bdabdabda/advertisements');
			exit();
		}
		else
		{
			if(isset($_POST['submit']))
			{
				// print_r($_POST);
				// echo "<br><br>";
				// print_r($_FILES);
				$status_file = array();
				$campaign_id = $_POST['campaign_id'];
				$this->adminadvertisements_model->update_campaign($_POST);

				if(isset($_FILES['ad_img_lres']['name']) && !empty($_FILES['ad_img_lres']['name']) && $_FILES['ad_img_lres']['error'] == 0)
				{
					$status_file['ad_img_lres'] = $this->upload_file($_FILES['ad_img_lres'], $campaign_id, 'low');
				}else{
					unset($status_file['ad_img_lres']);
				}
				
				if(isset($_FILES['ad_img_mres']['name']) && !empty($_FILES['ad_img_mres']['name']) && $_FILES['ad_img_mres']['error'] == 0)
				{
					$status_file['ad_img_mres'] = $this->upload_file($_FILES['ad_img_mres'], $campaign_id, 'medium');
				}else{
					unset($status_file['ad_img_mres']);
				}
				
				if(isset($_FILES['ad_img_hres']['name']) && !empty($_FILES['ad_img_hres']['name']) && $_FILES['ad_img_hres']['error'] == 0)
				{
					$status_file['ad_img_hres'] = $this->upload_file($_FILES['ad_img_hres'], $campaign_id, 'high');
				}else{
					unset($status_file['ad_img_hres']);
				}
				
				if(isset($_FILES['ad_img_ures']['name']) && !empty($_FILES['ad_img_ures']['name']) && $_FILES['ad_img_ures']['error'] == 0)
				{
					$status_file['ad_img_ures'] = $this->upload_file($_FILES['ad_img_ures'], $campaign_id, 'ultra');
				}else{
					unset($status_file['ad_img_ures']);
				}
				
				if(isset($status_file['ad_img_lres']) ||isset($status_file['ad_img_mres']) ||isset($status_file['ad_img_hres']) ||isset($status_file['ad_img_ures']))
				{
					$this->adminadvertisements_model->update_filenames($campaign_id, $status_file);
				}
				
				redirect("/bdabdabda/advertisements");
	//			redirect("/bdabdabda/advertisements/view_campaign/{$campaign_id}");
			}
			$this->data['all_details'] = $this->adminadvertisements_model->get_all_details_campaign($campaign_id);
			$this->data['perms']	=	$this->perms;
			$this->load->view('admin/advertisements_editcampaign', $this->data);
		}
	}

	function add_campaign()
	{
		$this->load->model('admin/adminpackages_model');
		$this->data['current_tab'] = $this->current_tab;
		$this->data['packages'] = $this->adminpackages_model->get_all_packages_list();
		
		if(isset($_POST['submit']))
		{
//			print_r($_POST);
//			echo "<br><br>";
//			print_r($_FILES);
			$status_file	=	array();
			$campaign_id = $this->adminadvertisements_model->add_campaign($_POST);

			if(isset($_FILES['ad_img_lres']['name']) && $_FILES['ad_img_lres']['error'] == 0)
				{
					$status_file['ad_img_lres'] = $this->upload_file($_FILES['ad_img_lres'], $campaign_id, 'low');
				}else{
					$status_file['ad_img_lres'] = NULL;
				}
				
				if(isset($_FILES['ad_img_mres']['name']) && $_FILES['ad_img_mres']['error'] == 0)
				{
					$status_file['ad_img_mres'] = $this->upload_file($_FILES['ad_img_mres'], $campaign_id, 'medium');
				}else{
					$status_file['ad_img_mres'] = NULL;
				}
				
				if(isset($_FILES['ad_img_hres']['name']) && $_FILES['ad_img_hres']['error'] == 0)
				{
					$status_file['ad_img_hres'] = $this->upload_file($_FILES['ad_img_hres'], $campaign_id, 'high');
				}else{
					$status_file['ad_img_hres'] = NULL;
				}
				
				if(isset($_FILES['ad_img_ures']['name']) && $_FILES['ad_img_ures']['error'] == 0)
				{
					$status_file['ad_img_ures'] = $this->upload_file($_FILES['ad_img_ures'], $campaign_id, 'ultra');
				}else{
					$status_file['ad_img_ures'] = NULL;
				}
				
				$this->adminadvertisements_model->insert_filenames($campaign_id, $status_file);
				
			redirect("/bdabdabda/advertisements");
//			redirect("/bdabdabda/advertisements/view_campaign/{$campaign_id}");
		}
		//$this->data['all_details'] = $this->adminadvertisements_model->get_all_details_campaign($campaign_id);
		$this->data['perms']	=	$this->perms;
		$this->load->view('admin/advertisements_addcampaign', $this->data);
	}
	
	function upload_file($filedata, $campaign_id, $filetype_res)
	{
		if($filedata['type'] == "image/jpeg" && $filedata['size'] <= '2000000')
		{
			$ok = 0;
//			echo getcwd();
//			var_dump(mkdir('media/ad/sfgfsdg'));
			
			$md = date('M').date('Y');
			
			$structure = "media/ad/".$md.'/';
			if(is_dir("media/ad/".$md))
			{
				$ok = 1;
			}
			else
			{
				if(!mkdir($structure))
				{
					echo('Failed to create folders...');
					return FALSE;
				}
				else
				{
					$ok = 1;
				}
			}
			if($ok == 1)
			{
				$extension = pathinfo($filedata["name"],PATHINFO_EXTENSION);
				$filename = $campaign_id.'_'.time().'_'.$filetype_res.'.'.$extension;
				$filename_path = $structure.$filename;
				if(move_uploaded_file($filedata["tmp_name"], $filename_path))
				{
					//echo "The file ". basename($filedata["name"]). " has been uploaded.";
					return $filename_path;
				}
				else
				{
					//echo "Sorry, there was an error uploading your file.";
					return FALSE;
				}
			}
		}
		else
		{
			$data['error'] = "Invalid file size/type";
			return FALSE;
		}
	}
	
	function delete_img()
	{
		if(isset($_GET['imgtype']) && !empty($_GET['imgtype']) && isset($_GET['campaignid']) && !empty($_GET['campaignid']) && is_numeric($_GET['campaignid']) && isset($_GET['imgname']) && !empty($_GET['imgname']))
		{
			$this->adminadvertisements_model->delete_image($_GET);
			unlink($_GET['imgname']);
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function add_doctor_campaign($campaign_id = NULL)
	{
		$this->data['current_tab'] = $this->current_tab;
		if($campaign_id !== NULL)
		{
			$this->load->model('admin/adminpackages_model');
			$this->load->model('admin/admindoctor_model');
			$this->load->model('admin/adminmasters_model');
			$this->data['speciality_master'] = $this->admindoctor_model->get_speciality_master();
			$this->data['city_master'] = $this->adminmasters_model->get_city_master();
			$search	=	array();
			if(isset($_REQUEST['submit']) && $_REQUEST['submit'] == 'Search')
			{
				if(isset($_REQUEST['doctor_name']) && !empty($_REQUEST['doctor_name']))
				{
					$search['doctor_name'] = $_REQUEST['doctor_name'];
				}
				else
				{
					$search['doctor_name'] = NULL;
				}
				if(isset($_REQUEST['speciality_id']) && !empty($_REQUEST['speciality_id']))
				{
					$search['speciality_id'] = $_REQUEST['speciality_id'];
				}
				else
				{
					$search['speciality_id'] = NULL;
				}
				if(isset($_REQUEST['city_id']) && !empty($_REQUEST['city_id']))
				{
					$search['city_id'] = $_REQUEST['city_id'];
				}
				else
				{
					$search['city_id'] = NULL;
				}
			}
			if(
			(isset($_REQUEST['submit'])) && 
				(
				(isset($_REQUEST['doctor_name']) && !empty($_REQUEST['doctor_name'])) ||
				(isset($_REQUEST['city_id']) && !empty($_REQUEST['city_id'])) ||
				(isset($_REQUEST['speciality_id']) && !empty($_REQUEST['speciality_id']))
				)
			)
			{
				$this->data['searchrecords'] = $this->adminadvertisements_model->get_doctors_list($search);
			}
			$this->data['no_of_doctors'] = $this->adminadvertisements_model->get_no_of_doctors($campaign_id);
			$this->data['campaign_doctors'] = $this->adminadvertisements_model->get_campaign_doctors($campaign_id);
			$this->data['campaign_id'] = $campaign_id;
			$this->data['perms']	=	$this->perms;
			$this->load->view('admin/advertisements_adddoctors', $this->data);
		}
		else
		{
			redirect('/bdabdabda/advertisements');
		}
	}
	
}
