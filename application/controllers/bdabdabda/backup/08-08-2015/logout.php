<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('admin/adminuser_model');
	}
	
	function index()
	{
		$this->session->unset_userdata('admin_id');
		$this->session->unset_userdata('admin_name');
		$this->session->unset_userdata('admin_user_type');
		$this->session->sess_destroy();
		redirect('/bdabdabda/');
		//$this->load->view('admin/home', isset($data) ? $data : NULL);
	}
}