<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Boxmanager extends CI_Controller
{
	private $current_tab = 'masters';
	public $perms	=	array();	

	function __construct()
	{
		parent::__construct();
		$this->load->library("pagination");
		$this->load->helper("url");
		$this->load->model(array('admin/adminboxmanager_model','boxmanager_model','media_model','admin/adminmasters_model'));

		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if($this->perms[ADMIN_MASTERS]['view']	==	0)
		{
			redirect(($admin_home_url)?$admin_home_url:'/bdabdabda');
			exit();
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

	function health_utsav()
	{
		$data['current_tab']	= $this->current_tab;
		$data['perms']				=	$this->perms;
		$data['section_type']	='health_usav';
		$data['display_name']	='Health Usav';

		$config['base_url'] = BASE_URL.'bdabdabda/boxmanager/health_utsav?';
		$config['per_page'] = 10;

		if(count($_GET) > 1)
		{
			$config['base_url'] = $config['base_url'] . http_build_query($_GET, '', '&');
		}
		$page = !empty($_GET['start']) ? $_GET['start'] : 0;
		if(isset($_POST['submit']))
		{
			if($_POST['submit'] == 'Enable')
			{
				$this->update_status('1', 'boxmanager');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0', 'boxmanager');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1', 'boxmanager');
			}
			
			// If new entry
			if($_POST['submit'] == 'Add Entry')
			{
				$json_data	=	 array();
				#multipart image upload code
				if(sizeof($_FILES)>0)
				{
					$this->media_model->upload_type='multipart';
					$this->media_model->content_type	=	'profile';
					foreach($_FILES['image']['name'] as $key=>$val)
					{
						$file													=	 array();
						$file['image']['name']				=	$val;
						$file['image']['type']				=	$_FILES['image']['type'][$key];
						$file['image']['tmp_name']		=	$_FILES['image']['tmp_name'][$key];
						$file['image']['error']				=	$_FILES['image']['error'][$key];
						$file['image']['size']				=	$_FILES['image']['size'][$key];
						$this->media_model->file_data	=	$file;
						$file_res	=	$this->media_model->upload();
						if($file_res)
						{
							$json_data[$key]['image']	=	$file_res[1];
							$json_data[$key]['url']	=	$_POST['url'][$key];
							$json_data[$key]['title']	=	$_POST['title'][$key];
						}
					}
				}
				if(!empty($_POST['city_id']))
				{
					$this->adminboxmanager_model->insert_data($data['section_type'],$json_data,$_POST['city_id'],$_POST['category_id'],$_POST['status'],$_POST['sort'],$_POST['name']);
				}
			}
		}
		$status				=	1;
		$city_id			=	0;
		$category_id	=	0;
		if(isset($_GET['submit']) && $_GET['submit'] == 'Search')
		{
			if(isset($_GET['status']) && strlen($_GET['status']) > 0)
			{
				$status = $_GET['status'];
			}
			if(isset($_GET['city_id']) && !empty($_GET['city_id']))
			{
				$city_id = $_GET['city_id'];
			}
			if(isset($_GET['category_id']) && !empty($_GET['category_id']))
			{
				$category_id = $_GET['category_id'];
			}
		}
		
		$config['total_rows'] = $this->boxmanager_model->get_data_count($data['section_type'],$city_id,$category_id);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->boxmanager_model->get_data($data['section_type'],$city_id,$category_id,$status,$config["per_page"],$page);
		
		$this->load->view('admin/boxmanager', $data);
	}
}