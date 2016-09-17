<?php
if( ! defined('BASEPATH')) exit('No direct script access allowed');

class logout extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		//Destroy user session
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('name');
		$this->session->unset_userdata('usertype');
		// Destroy the session completely
		//$this->session->sess_destroy();
		redirect('login', 'refresh');
	}
}
	
/* End of logout.php */