<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/adminuser_model');
	}
	
	function index()
	{
		$this->load->library('form_validation');
		if(isset($_POST['username']))
		{
			$config = array(
				array(
				'field'		=>	'username',
				'label'		=>	'Username',
				'rules'		=>	'required|trim'
				),
				array(
				'field'		=>	'password',
				'label'		=>	'Password',
				'rules'		=>	'required'
				)
			);
			$this->form_validation->set_rules($config);
			if($this->form_validation->run() === FALSE)
			{
				
			}
			else
			{
				$check = $this->adminuser_model->check_admin_login($_POST['username'], $_POST['password']);
				
				if($check)
				{
					$permissions	=	 $this->adminuser_model->get_permissions($check->id);
					$admin_home_url	=	$this->adminuser_model->login_admin($check,$permissions);
					redirect(($admin_home_url)?$admin_home_url:'/bdabdabda');
				}
				else
				{
					$data['errormsg'] = "Invalid login credentials";
				}
			}
		}
		$this->load->view('admin/login', isset($data) ? $data : NULL);
	}
}