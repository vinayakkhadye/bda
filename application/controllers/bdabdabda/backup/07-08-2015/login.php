<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/adminuser_model');
		$adminid = $this->session->userdata('admin_id');
		if(!empty($adminid))
		{
			redirect('/bdabdabda/home');
		}
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
					$this->adminuser_model->login_admin($check);
					redirect('/bdabdabda/home');
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