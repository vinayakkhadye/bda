<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class manage_adminusers extends CI_Controller
{
	private $current_tab = 'adminusers';
	private $perms	=	"";
	function __construct()
	{
		parent::__construct();
		$this->load->library("pagination");
		$this->load->helper("url");
		$this->load->model("admin/adminuser_model");
		

		$this->perms		=	$this->session->userdata('allowed_perms'); 
		$admin_home_url	=	$this->session->userdata('admin_home_url');
		if($this->perms[ADMIN_USER]['view']	==	0)
		{
			redirect($admin_home_url);
			exit();
		}
	}
	

	function index()
	{
		$data['current_tab'] = $this->current_tab;

		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] = TRUE;

		
		$config['base_url'] = BASE_URL.'bdabdabda/manage_adminusers/manage?';
		$config['per_page'] = 10;
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
				$this->update_status('1');
			}
			elseif($_POST['submit'] == 'Disable')
			{
				$this->update_status('0');
			}
			elseif($_POST['submit'] == 'Delete')
			{
				$this->update_status('-1');
			}
		}
		$search	=	NULL;
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
			if(isset($_GET['record_username']) && !empty($_GET['record_username']))
			{
				$search['record_username'] = $_GET['record_username'];
			}
		}

		$config['total_rows'] = $this->adminuser_model->get_total_records_count($search);
		$this->pagination->initialize($config); 
		$data['allrecords'] = $this->adminuser_model->get_adminusers_list($config["per_page"], $page, $search);
		$data['perms']	=	$this->perms;
		$this->load->view('admin/adminusers', $data);
	}
	
	function user_permissions($admin_user_name,$admin_user_id)
	{
		$data['permissions']	=	$this->adminuser_model->get_permissions($admin_user_id);
		$data['admin_user_name']	=	$admin_user_name;
		$data['admin_user_id']	=	$admin_user_id;
		$data['perms']	=	$this->perms;
		$this->load->view('admin/adminuser_permissions', $data);
	}
	function save_permissions()
	{
		$admin_user_id	=	(int)$this->post['admin_user_id'];
		if($admin_user_id)
		{
			foreach($this->post['permission'] as $key=>$val)
			{
				$perm_set_array['view']	=	isset($val['view'])?1:0;
				$perm_set_array['add']	=	isset($val['add'])?1:0;
				$perm_set_array['edit']	=	isset($val['edit'])?1:0;
				$perm_set_array['delete']	=	isset($val['delete'])?1:0;
				$perm_set_array['loginas']	=	isset($val['loginas'])?1:0;
				$perm_set_array['search']	=	isset($val['search'])?1:0;
				$this->adminuser_model->add_permissions($admin_user_id,$key,$perm_set_array);
			}
		}
	}
	
	function new_user()
	{
		$data['current_tab'] = $this->current_tab;
		if(isset($_POST['submit']))
		{
			$this->adminuser_model->add_new_adminuser($_POST);
			redirect('/bdabdabda/manage_adminusers');
		}
		$data['perms']	=	$this->perms;
		$this->load->view('admin/adminusers_adduser', $data);
	}

	function edit_user($userid = NULL)
	{
		if(!empty($userid))
		{
			$data['current_tab'] = $this->current_tab;
			if(isset($_POST['submit']))
			{
				$this->adminuser_model->edit_adminuser($_POST, $userid);
				//redirect('/bdabdabda/manage_adminusers');
			}
			$userdetails = $this->adminuser_model->get_user_details($userid);
			if($userdetails !== FALSE)
			{
				$data['userdetails'] = $userdetails;
			}
			else
			{
				redirect('/bdabdabda/manage_adminusers');
			}
			$data['perms']	=	$this->perms;
			$this->load->view('admin/adminusers_edituser', $data);
		}
	}

	function view_user($userid = NULL)
	{
		if(!empty($userid))
		{
			$data['current_tab'] = $this->current_tab;
			if(isset($_POST['submit']))
			{
				$this->adminuser_model->edit_adminuser($_POST, $userid);
				redirect('/bdabdabda/manage_adminusers');
			}
			$userdetails = $this->adminuser_model->get_user_details($userid);
			if($userdetails !== FALSE)
			{
				$data['userdetails'] = $userdetails;
			}
			else
			{
				redirect('/bdabdabda/manage_adminusers');
			}
			$data['perms']	=	$this->perms;
			$this->load->view('admin/adminusers_viewuser', $data);
		}
	}

	function update_permission()
	{
		echo $userid= $_POST['userid'];
		echo $permissiontype = $_POST['permissiontype'];
		echo $status = $_POST['status'];
		
		if(is_numeric($userid) && !empty($userid) && !empty($permissiontype) && is_numeric($status) && strlen($status)>0)
		{
			$this->adminuser_model->update_permission_byid($userid, $permissiontype, $status);
		}
	}

	function update_status($status)
	{
		$ids = array_keys($this->post['record_id']);
		$this->adminuser_model->update_status($status, $ids);
	}
	
}